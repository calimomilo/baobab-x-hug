<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Season;
use Inertia\Inertia;

class DisplayController extends Controller
{
    /**
     * Displays Home Page.
     */
    public function displayHome()
    {
        // $season = Season::where('')
        $entreprises = Company::all();

        return Inertia::render('Home');
    }
}
