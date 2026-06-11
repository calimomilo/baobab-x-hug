<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Company;
use App\Models\Season;
use App\Services\BloodLeagueScorer;
use Carbon\Carbon;
use Carbon\CarbonInterface;
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

            if (! $label) {
                $company->label = [
                    'name' => 'Aucune participation',
                    'slug' => 'outsider',
                ];
            } else {
                $company->label = [
                    'name' => $label->name(),
                    'slug' => $label,
                ];
            }
        });

        $base = $companies->where('anonymous', '=', 0)->select(['company_name', 'logo_url', 'label']);

        if ($slug) {
            $company = Company::where('slug', $slug)->with('collects')->first();

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

            $collect = $company->collects->where('date_of', '>=', today())->sortBy('date_of')->first();

            if ($collect) {
                $collect->countdown = new Carbon($collect->date_of)->locale('fr')->diffForHumans(null, CarbonInterface::DIFF_ABSOLUTE, false, 4);
                $collect->date_of = new Carbon($collect->date_of)->locale('fr')->format('j.m.o');
                $collect->start_time = new Carbon($collect->start_time)->format('G\hi');
                $collect->end_time = new Carbon($collect->end_time)->format('G\hi');
            }
        }

        return Inertia::render('Home', ['companies' => $base, 'displayData' => $companyDisplayData ?? null, 'collect' => $collect ?? null]);
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
        $season = Season::where('status', 'open')->with('collects')->first();
        $collectIds = $season->collects->pluck('company_id');
        $companies = Company::whereIn('id', $collectIds)->get();
        $companies->map(function ($company) use ($season) {
            $label = app(BloodLeagueScorer::class)->computeLabel($company->id, $season->id);

            if (! $label) {
                $company->label = [
                    'name' => 'Aucune participation',
                    'slug' => 'outsider',
                ];
            } else {
                $company->label = [
                    'name' => $label->name(),
                    'slug' => $label,
                ];
            }

            $score = app(BloodLeagueScorer::class)->computeScore($company->id, $season->id);
            $company->total = $score['total'];
            $company->score = [
                'donations' => $score['raw']['donations'],
                'supporters' => $score['raw']['supporter_shares'],
                'efficiency' => $score['raw']['taux_efficacite'],
            ];
        });

        $base = $companies->where('anonymous', '=', 0)->sortByDesc('score.total')->select(['company_name', 'logo_url', 'label', 'score']);

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

        return Inertia::render('Leaderboard', ['companies' => $base, 'season' => $season->year_of, 'displayData' => $companyDisplayData ?? null]);
    }

    public function displayChecker(string $slug, ?string $step = null)
    {
        if ($slug) {
            $company = Company::where('slug', $slug)->with('collects')->first();

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

            $collect = $company->collects->where('date_of', '>=', today())->sortBy('date_of')->first();

            if (! $collect) {
                return to_route('conditions.slug', $company->slug);
            }

            if ($step !== null && (! is_numeric($step) || $step < 1)) {
                return to_route('checker', ['slug' => $company->slug, 'step' => null]);
            }

            $base = [
                'id' => $collect->id,
                'appointment_link' => $collect->appointment_link,
            ];

            return Inertia::render('Checker', ['displayData' => $companyDisplayData, 'collect' => $base, 'step' => $step]);
        }
    }

    public function displayAdmin()
    {
        $season = Season::where('status', 'open')->with('collects.data')->first();

        if (! $season) {
            return to_route('seasons.open');
        }

        $season->wins = app(BloodLeagueScorer::class)->electWinners($season->id);

        $collectIds = $season->collects->pluck('company_id');
        $companies = Company::whereIn('id', $collectIds)->get();
        $companies->map(function ($company) use ($season) {
            $label = app(BloodLeagueScorer::class)->computeLabel($company->id, $season->id);

            if (! $label) {
                $company->label = [
                    'name' => 'Aucune participation',
                    'slug' => 'outsider',
                ];
            } else {
                $company->label = [
                    'name' => $label->name(),
                    'slug' => $label,
                ];
            }

            $score = app(BloodLeagueScorer::class)->computeScore($company->id, $season->id);
            $company->score = $score;
        });

        $season->collects->map(function ($collect) {
            $collect->donor_results = $collect->data->where('data_type', DataType::DONOR_RESULT)->count();
            $collect->supporter_results = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();
            $collect->appointment_clicks = $collect->data->where('data_type', DataType::APPOINTMENT_CLIC)->count();
            $collect->donor_shares = $collect->data->where('data_type', DataType::DONOR_SHARE)->count();
            $collect->supporter_shares = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();

            $collect->makeHidden('data');
        });

        return Inertia::render('admin/Dashboard', ['season' => $season, 'companies' => $companies]);
    }
}
