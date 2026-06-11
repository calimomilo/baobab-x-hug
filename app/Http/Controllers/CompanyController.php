<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Enums\DataType;
use App\Models\Company;
use App\Models\Season;
use App\Services\BloodLeagueScorer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the company.
     */
    public function index()
    {
        $season = Season::where('status', 'open')->first();

        $companies = Company::orderBy('company_name', 'asc')->with('collects')->get();

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

            $seasonCollects = $company->collects->where('season_id', $season->id);
            $company->currentCollects = $seasonCollects->count();
        });

        $companies->makeHidden('collects');

        return Inertia::render('admin/Companies', ['season' => $season, 'companies' => $companies]);
    }

    /**
     * Show the form for creating a new company.
     */
    public function create()
    {
        // return page inertia /companies/create
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|min:2|max:255',
            'address' => 'required|string',
            'contact_address' => 'nullable|string',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'slug' => 'required|string|alpha_dash:ascii|min:4|max:42|unique:companies',
            'primary_color' => 'required|hex_color',
            'secondary_color' => 'required|hex_color',
            'logo_url' => 'required|image',
            'anonymous' => 'required|boolean',
        ]);

        $company = Company::create([
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
            'contact_address' => $validated['contact_address'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'slug' => $validated['slug'],
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'logo_url' => $validated['logo_url'],
            'anonymous' => $validated['anonymous'],
        ]);

        // return page inertia /companies/$company->slug
    }

    /**
     * Display the specified company.
     */
    public function show(string $id)
    {
        $season = Season::where('status', 'open')->first();

        $company = Company::with([
            'wins',
            'collects' => [
                'season',
                'data',
            ],
        ])->findOrFail($id);

        $company->wins->map(function ($win) {
            $win->pivot->slug = Category::from($win->pivot->category)->slug();
            $win->pivot->label = Category::from($win->pivot->category)->label();
        });

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

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

        $company->collects->map(function ($collect) {
            $collect->donor_results = $collect->data->where('data_type', DataType::DONOR_RESULT)->count();
            $collect->supporter_results = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();
            $collect->appointment_clicks = $collect->data->where('data_type', DataType::APPOINTMENT_CLIC)->count();
            $collect->donor_shares = $collect->data->where('data_type', DataType::DONOR_SHARE)->count();
            $collect->supporter_shares = $collect->data->where('data_type', DataType::SUPPORTER_RESULT)->count();

            $collect->makeHidden('data');
        });

        return Inertia::render('admin/Company', ['seasons' => Season::all(), 'company' => $company]);
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        // return page inertia /companies/$company->slug/edit
    }

    /**
     * Update the specified company in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|min:2|max:255',
            'address' => 'required|string|max:500',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'slug' => 'required|string|alpha_dash:ascii|min:4|max:50|unique:companies',
            'primary_color' => 'required|hex_color',
            'secondary_color' => 'required|hex_color',
            'logo_url' => 'required|image',
            'anonymous' => 'required|boolean',
        ]);

        $company = Company::findOrFail($id);

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $company->updateOrFail([
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'slug' => $validated['slug'],
            'primary_color' => $validated['primary_color'],
            'secondary_color' => $validated['secondary_color'],
            'logo_url' => $validated['logo_url'],
            'anonymous' => $validated['anonymous'],
        ]);

        // return page inertia /companies/$company->slug
    }

    /**
     * Remove the specified company from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $company->deleteOrFail();

        // return page inertia /companies
    }
}
