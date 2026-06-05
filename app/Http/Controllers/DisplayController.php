<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Season;
use App\Services\BloodLeagueScorer;
use Inertia\Inertia;

class DisplayController extends Controller
{
    /**
     * Displays Home Page.
     */
    public function displayHome()
    {
        $collectIds = Season::where('status', 'open')->with('collects')->first()->collects->pluck('company_id');
        $companies = Company::whereIn('id', $collectIds)->get();
        $companies->map(function ($company) {
            $label = app(BloodLeagueScorer::class)->computeLabel($company->id, 2);
            $company->label = [
                'name' => $label->name(),
                'slug' => $label,
            ];
        });

        $base = $companies->select(['company_name', 'logo_url', 'label']);

        return Inertia::render('Home', ['companies' => $base]);
    }

    public function displayDonDuSang()
    {
        return Inertia::render('DonDuSang');
    }

    public function displayBloodLeague()
    {
        return Inertia::render('BloodLeague');
    }

    public function displayLeaderboard()
    {
        $season = Season::where('status', 'open')->with('collects')->first();
        $collectIds = $season->collects->pluck('company_id');
        $companies = Company::whereIn('id', $collectIds)->get();
        $companies->map(function ($company) use ($season) {
            $label = app(BloodLeagueScorer::class)->computeLabel($company->id, $season->id);
            $company->label = [
                'name' => $label->name(),
                'slug' => $label,
            ];

            $score = app(BloodLeagueScorer::class)->computeScore($company->id, $season->id);
            $company->total = $score['total'];
            $company->score = [
                'donations' => $score['raw']['donations'],
                'supporters' => $score['raw']['supporter_shares'],
                'efficiency' => $score['raw']['taux_efficacite'],
            ];
        });

        $base = $companies->sortBy('score.total')->select(['company_name', 'logo_url', 'label', 'score']);

        return Inertia::render('Leaderboard', ['companies' => $base, 'season' => $season->year_of]);
    }
}
