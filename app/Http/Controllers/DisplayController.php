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
        // $season = Season::where('')
        $companies = Company::all();
        $companies->map(function ($company) {
            $label = app(BloodLeagueScorer::class)->computeLabel($company->id, 2);
            $company->label = [
                'name' => $label->name(),
                'slug' => $label,
            ];
        });

        echo $companies;

        return Inertia::render('Home', ['companies' => $companies]);
    }
}
