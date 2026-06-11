<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Enums\SeasonStatus;
use App\Models\Collect;
use App\Models\Company;
use App\Models\Season;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CollectController extends Controller
{
    /**
     * Display a listing of the collect.
     */
    public function index()
    {
        $collects = Collect::orderBy('date_of', 'desc')->with(['company', 'season', 'data'])->get();

        $collects->map(function ($collect) {
            $collect->donor_results = $collect->data->where('data_type', DataType::DONOR_RESULT)->count();
            $collect->supporter_results = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();
            $collect->appointment_clicks = $collect->data->where('data_type', DataType::APPOINTMENT_CLIC)->count();
            $collect->donor_shares = $collect->data->where('data_type', DataType::DONOR_SHARE)->count();
            $collect->supporter_shares = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();

            $collect->makeHidden('data');
        });

        return Inertia::render('admin/Collects', ['collects' => $collects]);
    }

    /**
     * Show the form for creating a new collect.
     */
    public function create()
    {
        $companies = Company::all();
        $seasons = Season::all();

        return Inertia::render('admin/CollectForm', ['companies' => $companies, 'seasons' => $seasons]);
    }

    /**
     * Store a newly created collect in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_of' => 'required|date|after:now',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:500',
            'appointment_link' => 'required|string|max:500',
            'employees' => 'required|integer|min:0',
            'season_year' => 'required|date_format:Y',
        ]);

        $company = Company::findOrFail($request->company_id);
        $season = Season::where('year_of', $validated['season_year'])->first();

        if (! $season) {
            $season = Season::create([
                'year_of' => $validated['season_year'],
                'status' => SeasonStatus::FUTURE,
            ]);
        }

        $collect = new Collect;

        $collect->date_of = $validated['date_of'];
        $collect->start_time = $validated['start_time'];
        $collect->end_time = $validated['end_time'];
        $collect->location = $validated['location'];
        $collect->appointment_link = $validated['appointment_link'];
        $collect->employees = $validated['employees'];
        $collect->appointments = 0;
        $collect->donations = 0;
        $collect->completed = 0;

        $collect->company()->associate($company);
        $collect->season()->associate($season);

        $collect->save();

        return to_route('collects.show', ['collect' => $collect]);
    }

    /**
     * Display the specified collect.
     */
    public function show(string $id)
    {
        $collect = Collect::with(['company', 'season', 'data'])->findOrFail($id);

        $collect->donor_results = $collect->data->where('data_type', DataType::DONOR_RESULT)->count();
        $collect->supporter_results = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();
        $collect->appointment_clicks = $collect->data->where('data_type', DataType::APPOINTMENT_CLIC)->count();
        $collect->donor_shares = $collect->data->where('data_type', DataType::DONOR_SHARE)->count();
        $collect->supporter_shares = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();

        $collect->makeHidden('data');

        return Inertia::render('admin/Collect', ['collect' => $collect]);
    }

    /**
     * Show the form for editing the specified collect.
     */
    public function edit(string $id)
    {
        $companies = Company::all();
        $seasons = Season::all();
        $collect = Collect::with(['season', 'company'])->findOrFail($id);

        return Inertia::render('admin/CollectForm', ['companies' => $companies, 'seasons' => $seasons, 'formData' => $collect]);
    }

    /**
     * Update the specified collect in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'date_of' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:500',
            'appointment_link' => 'required|string|max:500',
            'employees' => 'required|integer|min:0',
            'season_year' => 'required|date_format:Y',
        ]);

        $collect = Collect::findOrFail($id);
        $season = Season::where('year_of', $validated['season_year'])->first();

        if (! $season) {
            $season = Season::create([
                'year_of' => $validated['season_year'],
                'status' => SeasonStatus::FUTURE,
            ]);
        }

        if ($season->status === SeasonStatus::CLOSED->value) {
            return;
        }

        $collect->updateOrFail([
            'date_of' => $validated['date_of'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'appointment_link' => $validated['appointment_link'],
            'employees' => $validated['employees'],
        ]);

        return to_route('collects.show', ['collect' => $collect]);
    }

    /**
     * Remove the specified collect from storage.
     */
    public function destroy(string $id)
    {
        $collect = Collect::findOrFail($id);

        $collect->deleteOrFail();

        return to_route('collects.index');
    }

    /**
     * Mark the specified collect as complete
     */
    public function complete(Request $request, string $id)
    {
        $validated = $request->validate([
            'appointments' => 'required|integer|min:0',
            'donations' => 'required|integer|min:0',
        ]);

        $collect = Collect::findOrFail($id);

        $collect->appointments = $validated['appointments'];
        $collect->donations = $validated['donations'];
        $collect->completed = 1;

        $collect->save();

        return to_route('collects.show', ['collect' => $collect]);
    }

    /**
     * Mark the specified collect as incomplete
     */
    public function incomplete(string $id)
    {
        $collect = Collect::with('season')->findOrFail($id);

        if ($collect->season->status === SeasonStatus::CLOSED->value) {
            return;
        }

        $collect->completed = 0;
        $collect->save();

        return to_route('collects.show', ['collect' => $collect]);
    }
}
