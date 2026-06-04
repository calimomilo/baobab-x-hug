<?php

namespace App\Services;

use App\Enums\Label;
use App\Models\Collect;
use App\Models\Company;
use App\Models\Season;
use Illuminate\Support\Facades\DB;

class BloodLeagueScorer
{
    /**
     * Calcule le score complet d'une entreprise pour une saison
     */
    public function computeScore(int $companyId, int $seasonId): array
    {
        $collects = Collect::where('company_id', $companyId)
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

    public function computeLabel(int $companyId, int $seasonId): ?Label
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
            return Label::LEGEND;
        }
        if ($percentile <= 50) {
            return Label::GOLD;
        }

        return Label::CLASSIC;
    }

    /**
     * @return array<string, array{company_id: int|null, value: float|null}>
     */
    public function electWinners(int $seasonId): array
    {
        $previousSeasonId = $this->previousSeasonId($seasonId);

        $winners = [
            'climber' => ['company_id' => null, 'value' => null],
            'flood' => ['company_id' => null, 'value' => null],
            'pulse' => ['company_id' => null, 'value' => null],
            'new_vein' => ['company_id' => null, 'value' => null],
        ];

        foreach (Company::pluck('id', null) as $companyId) {
            $score = $this->computeScore($companyId, $seasonId);

            if ($score['total'] === 0) {
                continue;
            }

            $raw = $score['raw'];

            // The Flood — taux de participation
            $winners['flood'] = $this->challenge($winners['flood'], $companyId, $raw['taux_participation']);

            // The Pulse — supporters
            $winners['pulse'] = $this->challenge($winners['pulse'], $companyId, $raw['taux_supporters']);

            // The Climber — progression du score total vs saison précédente
            if ($previousSeasonId !== null) {
                $previousTotal = $this->computeScore($companyId, $previousSeasonId)['total'];
                if ($previousTotal > 0) {
                    $progression = (($score['total'] - $previousTotal) / $previousTotal) * 100;
                    $this->challenge($winners['climber'], $companyId, $progression);
                }
            }

            // The New Vein — meilleur taux d'efficacité parmi les nouvelles entreprises
            if ($this->isNewcomer($companyId, $seasonId)) {
                $this->challenge($winners['new_vein'], $companyId, $score['total']);
            }
        }

        // $this->persistWinners($seasonId, $winners);

        return $winners;
    }

    /**
     * maj le vanqueur si le candidat fait mieux
     */
    private function challenge(array &$current, int $companyId, float $value): array
    {
        if ($current['value'] === null || $value > $current['value']) {
            $current = ['company_id' => $companyId, 'value' => $value];
        }

        return $current;
    }

    /**
     * id saison précédente
     */
    private function previousSeasonId(int $seasonId): ?int
    {
        $season = Season::find($seasonId, '*');

        if ($season === null) {
            return null;
        }

        return Season::where('year_of', '<', $season->year_of, true)
            ->orderByDesc('year_of')
            ->value('id');
    }

    private function isNewcomer(int $companyId, int $seasonId): bool
    {
        $currentYear = Season::where('id', '=', $seasonId, true)->value('year_of');

        if ($currentYear === null) {
            return false;
        }

        $participatedBefore = Collect::where('company_id', '=', $companyId, true)
            ->where('completed', 1)
            ->whereHas('season', fn ($q) => $q->where('year_of', '<', $currentYear))
            ->exists();

        return ! $participatedBefore;
    }

    /**
     * maj les vainqueurs dans la table winnnnnnnnns
     *
     * @param  array<string, array{company_id: int|null, value: float|null}>  $winners
     */
    private function persistWinners(int $seasonId, array $winners): void
    {
        $now = now();

        foreach ($winners as $category => $winner) {
            if ($winner['company_id'] === null) {
                continue; // pas de vainqueur
            }

            DB::table('wins')->updateOrInsert(
                ['season_id' => $seasonId, 'category' => $category],
                ['company_id' => $winner['company_id'], 'created_at' => $now, 'updated_at' => $now],
            );
        }
    } // mon cerveau va exploser

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
