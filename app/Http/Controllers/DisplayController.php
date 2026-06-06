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
    public function displayHome(?string $slug = null)
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

        $base = $companies->where('anonymous', '=', 0)->select(['company_name', 'logo_url', 'label']);

        if ($slug) {
            $company = Company::where('slug', $slug)->first();

            if (! $company) {
                return to_route('home');
            }

            $companyDisplayData = [
                'name' => $company->company_name,
                'slug' => $company->slug,
                'primary_color' => $company->primary_color,
                'secondary_color' => $company->secondary_color,
                'logo_url' => $company->logo_url,
            ];
        }

        return Inertia::render('Home', ['companies' => $base, 'displayData' => $companyDisplayData ?? null]);
    }

    public function displayDonDuSang(?string $slug = null)
    {
        if ($slug) {
            $company = Company::where('slug', $slug)->first();

            if (! $company) {
                return to_route('home');
            }

            $companyDisplayData = [
                'name' => $company->company_name,
                'slug' => $company->slug,
                'primary_color' => $company->primary_color,
                'secondary_color' => $company->secondary_color,
                'logo_url' => $company->logo_url,
            ];
        }

        return Inertia::render('DonDuSang', ['displayData' => $companyDisplayData ?? null]);
    }

    public function displayBloodLeague(?string $slug = null)
    {
        if ($slug) {
            $company = Company::where('slug', $slug)->first();

            if (! $company) {
                return to_route('home');
            }

            $companyDisplayData = [
                'name' => $company->company_name,
                'slug' => $company->slug,
                'primary_color' => $company->primary_color,
                'secondary_color' => $company->secondary_color,
                'logo_url' => $company->logo_url,
            ];
        }

        return Inertia::render('BloodLeague', ['displayData' => $companyDisplayData ?? null]);
    }

    public function displayLeaderboard(?string $slug = null)
    {
        if ($slug) {
            $company = Company::where('slug', $slug)->first();

            if (! $company) {
                return to_route('home');
            }

            $companyDisplayData = [
                'name' => $company->company_name,
                'slug' => $company->slug,
                'primary_color' => $company->primary_color,
                'secondary_color' => $company->secondary_color,
                'logo_url' => $company->logo_url,
            ];
        }

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

        $base = $companies->where('anonymous', '=', 0)->sortBy('score.total')->select(['company_name', 'logo_url', 'label', 'score']);

        return Inertia::render('Leaderboard', ['companies' => $base, 'season' => $season->year_of, 'displayData' => $companyDisplayData ?? null]);
    }
}
