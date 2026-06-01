<?php

namespace App\Services;

use App\Models\Collect;
use App\Models\Company;

class BloodLeagueScorer
{
    /**
     * Calcule le score complet d'une entreprise pour une saison
     */
    public function computeScore(int $companyId, int $seasonId): array
    {
        $collects = Collect::where('company_id', '=', $companyId, true)
            ->where('season_id', $seasonId)
            ->where('completed', '=', 1) // ne compter que les collectes terminées
            ->with('data')
            ->get();

        $totalAppointments = $collects->pluck('appointments')->sum();
        $totalDonations = $collects->pluck('donations')->sum();
        $totalEmployees = $collects->pluck('employees')->sum();

        // Compte les supporters (type supporter_result)
        $totalSupporters = $collects->reduce(function ($carry, $item) {
            $supporters = $item->data->where('data_type', '=', 'supporter_result')->count();

            return $carry + $supporters;
        }, 0);

        // Compte les supporters actifs (type supporter_share)
        $totalSupporterShares = $collects->reduce(function ($carry, $item) {
            $shares = $item->data->where('data_type', '=', 'supporter_share')->count();

            return $carry + $shares;
        }, 0);

        $efficacite = $this->scoreEfficacite($totalAppointments, $totalDonations);
        $frequence = $this->scoreFrequence($collects->count());
        $donneurs = $this->scoreDonneurs($totalEmployees, $totalDonations);
        $supporters = $this->scoreSupporters($totalSupporters, $totalSupporterShares);

        return [
            'efficacite' => $efficacite,
            'frequence' => $frequence,
            'donneurs' => $donneurs,
            'supporters' => $supporters,
            'total' => $efficacite + $frequence + $donneurs + $supporters,
            'max' => 102,
            // Données brutes pour debug / affichage
            'raw' => [
                'collects_count' => $collects->count(),
                'appointments' => $totalAppointments,
                'donations' => $totalDonations,
                'supporters' => $totalSupporters,
                'supporter_shares' => $totalSupporterShares,
                'employees' => $totalEmployees,
                'taux_efficacite' => $totalAppointments > 0
                    ? round(($totalDonations / $totalAppointments) * 100, 2)
                    : 0,
                'taux_participation' => $totalEmployees > 0
                    ? round(($totalDonations / $totalEmployees) * 100, 2)
                    : 0,
                'taux_supporters' => $totalSupporters > 0
                    ? round(($totalSupporterShares / $totalSupporters) * 100, 2)
                    : 0,
            ],
        ];
    }

    public function computeLabel(int $companyId, int $seasonId): ?string
    {
        $myScore = $this->computeScore($companyId, $seasonId)['total'];

        if ($myScore === 0) {
            return null; // pas participé
        }

        // Récupère les scores de toutes les entreprises de cette saison
        $allCompanies = Company::pluck('id', null);
        $scores = [];
        foreach ($allCompanies as $id) {
            $s = $this->computeScore($id, $seasonId)['total'];
            if ($s > 0) {
                $scores[] = $s;
            }
        }

        rsort($scores);
        $rank = array_search($myScore, $scores);
        $percentile = ($rank / count($scores)) * 100;

        if ($percentile <= 15) {
            return 'Blood Legend';
        }
        if ($percentile <= 50) {
            return 'Blood Gold';
        }

        return 'Blood';
    }

    // ============== Sous-scores ==============

    /**
     * Efficacité (40 pts max) — ratio dons / inscriptions
     */
    private function scoreEfficacite(int $appointments, int $donations): int
    {
        if ($appointments === 0) {
            return 0;
        }
        $taux = ($donations / $appointments) * 100;

        return match (true) {
            $taux >= 90 => 40,
            $taux >= 75 => 32,
            $taux >= 50 => 24,
            $taux >= 25 => 16,
            $taux >= 10 => 8,
            $taux >= 1 => 2,
            default => 0,
        };
    }

    /**
     * Fréquence (20 pts max) — nombre de collectes réalisées
     */
    private function scoreFrequence(int $count): int
    {
        return match (true) {
            $count >= 4 => 20,
            $count === 3 => 15,
            $count === 2 => 10,
            $count === 1 => 5,
            default => 0,
        };
    }

    /**
     * Taux de donneurs (30 pts max) — dons / effectif total
     */
    private function scoreDonneurs(int $employees, int $donations): int
    {
        if ($employees === 0) {
            return 0;
        }
        $taux = ($donations / $employees) * 100;

        return match (true) {
            $taux >= 90 => 30,
            $taux >= 75 => 24,
            $taux >= 50 => 18,
            $taux >= 25 => 12,
            $taux >= 10 => 6,
            $taux >= 1 => 2,
            default => 0,
        };
    }

    /**
     * Supporters (12 pts max) — supporters mobilisés / effectif
     */
    private function scoreSupporters(int $supporters, int $supporterShares): int
    {
        if ($supporters === 0) {
            return 0;
        }
        $taux = ($supporterShares / $supporters) * 100;

        return match (true) {
            $taux >= 90 => 12,
            $taux >= 75 => 10,
            $taux >= 50 => 8,
            $taux >= 25 => 6,
            $taux >= 10 => 4,
            $taux >= 1 => 2,
            default => 0,
        };
    }
}
