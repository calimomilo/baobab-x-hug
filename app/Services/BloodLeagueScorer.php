<?php

namespace App\Services;

use App\Enums\Label;
use Illuminate\Support\Facades\DB;

class BloodLeagueScorer
{
    /**
     * Calcule le score complet d'une entreprise pour une saison
     */
    public function computeScore(int $companyId, int $seasonId): array
    {
        $collects = DB::table('collects')
            ->where('company_id', $companyId)
            ->where('season_id', $seasonId)
            ->where('donations', '>', 0) // ne compter que les collectes terminées
            ->get();

        $totalAppointments = $collects->sum('appointments');
        $totalDonations = $collects->sum('donations');
        $employees = $collects->first()->employees ?? 0;

        // Compte les supporters via collect_data (type supporter_result)
        $totalSupporters = DB::table('collect_data')
            ->whereIn('collect_id', $collects->pluck('id'))
            ->where('data_type', 'supporter_result')
            ->count();

        $efficacite = $this->scoreEfficacite($totalAppointments, $totalDonations);
        $frequence = $this->scoreFrequence($collects->count());
        $donneurs = $this->scoreDonneurs($employees, $totalDonations);
        $supporters = $this->scoreSupporters($employees, $totalSupporters);

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
                'employees' => $employees,
                'taux_efficacite' => $totalAppointments > 0
                    ? round(($totalDonations / $totalAppointments) * 100, 2)
                    : 0,
                'taux_participation' => $employees > 0
                    ? round(($totalDonations / $employees) * 100, 2)
                    : 0,
                'taux_supporters' => $employees > 0
                    ? round(($totalSupporters / $employees) * 100, 2)
                    : 0,
            ],
        ];
    }

    public function computeLabel(int $companyId, int $seasonId): ?Label
    {
        $myScore = $this->computeScore($companyId, $seasonId)['total'];

        if ($myScore === 0) {
            return null; // pas participé
        }

        // Récupère les scores de toutes les entreprises de cette saison
        $allCompanies = DB::table('companies')->pluck('id');
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
            return Label::LEGEND;
        }
        if ($percentile <= 50) {
            return Label::GOLD;
        }

        return Label::CLASSIC;
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
    private function scoreSupporters(int $employees, int $supporters): int
    {
        if ($employees === 0) {
            return 0;
        }
        $taux = ($supporters / $employees) * 100;

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
