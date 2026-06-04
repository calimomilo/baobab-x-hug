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
}
