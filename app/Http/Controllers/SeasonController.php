<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Enums\SeasonStatus;
use App\Models\Company;
use App\Models\Season;
use App\Services\BloodLeagueScorer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SeasonController extends Controller
{
    /**
     * Display the specified season.
     */
    public function show(string $id)
    {
        // Si on a le temps, voir comment on affiche le dashboard pour faire pareil

        // return page inertia /seasons/$seasons->year
    }

    /**
     * Show the form for opening a new season.
     */
    public function showOpen()
    {
        // return page inertia /season/open
    }

    /**
     * Open the specified season.
     */
    public function open(Request $request)
    {
        $validated = $request->validate([
            'season_year' => 'required|date_format:Y',
        ]);

        $season = Season::where('year_of', '=', $validated['season_year'], true)->firstOrCreate([
            'year_of' => $validated['season_year'],
            'status' => SeasonStatus::FUTURE,
        ]);

        $season->status = SeasonStatus::OPEN;

        // return inertia page dashboard
    }

    /**
     * Show the form for closing the specified season.
     */
    public function showClose(string $id)
    {
        $season = Season::with('collects')->findOrFail($id);

        if ($season->status == SeasonStatus::CLOSED->value) {
            return to_route('dashboard');
        }

        $companies = Company::get(['id', 'company_name']);
        $winners = app(BloodLeagueScorer::class)->electWinners($season->id);

        return Inertia::render('admin/SeasonClose', ['companies' => $companies, 'season' => $season, 'winners' => $winners]);
    }

    /**
     * Close the specified season.
     */
    public function close(Request $request, string $id)
    {
        $validated = $request->validate([
            'climber' => 'required|integer|exists:companies,id',
            'flood' => 'required|integer|exists:companies,id',
            'pulse' => 'required|integer|exists:companies,id',
            'new_vein' => 'nullable|integer|exists:companies,id',
            'golden_heart' => 'required|integer|exists:companies,id',
        ]);

        $season = Season::findOrFail($id);

        $season->wins()->attach([
            $validated['climber'] => ['category' => Category::THE_CLIMBER],
            $validated['flood'] => ['category' => Category::THE_FLOOD],
            $validated['pulse'] => ['category' => Category::THE_PULSE],
            $validated['golden_heart'] => ['category' => Category::THE_GOLDEN_HEART],
        ]);

        if ($validated['new_vein']) {
            $season->wins()->attach($validated['new_vein'], ['category' => Category::THE_NEW_VEIN]);
        }

        $season->status = SeasonStatus::CLOSED;

        return to_route('season.open');
    }

    /**
     * Show the form for editing the specified season.
     */
    public function edit(string $id)
    {
        $season = Season::findOrFail($id);

        if ($season->status === SeasonStatus::CLOSED) {
            return response()->json(['message' => 'Season closed.'], 422); // vérifier si ça fait pas n'imp en front, redirect
        }

        // return page inertia /seasons/season->year/edit
    }

    /**
     * Update the specified season in storage.
     */
    public function update(Request $request, string $id)
    {
        $season = Season::findOrFail($id);

        if ($season->status === SeasonStatus::CLOSED) {
            return response()->json(['message' => 'Season closed.'], 422); // vérifier si ça fait pas n'imp en front, redirect
        }

        $validated = $request->validate([
            'season_year' => ['required|date_format:Y', Rule::unique('seasons')->ignore($id)],
        ]);

        $season->updateOrFail([
            'year_of' => $validated['season_year'],
        ]);

        // return page inertia /dashboard
    }

    /**
     * Remove the specified season from storage.
     */
    public function destroy(string $id)
    {
        $season = Season::findOrFail($id);

        $season->deleteOrFail();

        return to_route('seasons.open');
    }
}
