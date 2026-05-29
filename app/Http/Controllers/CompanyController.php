<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->with('collects.data')->get();

        // return page inertia /companies
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return page inertia /companies/create
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|min:2|max:255',
            'address' => 'required|string',
            'contact_name' => 'nullable|string|max:255',
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
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $company = Company::with([
            'wins',
            'collect' => [
                'season',
                'data',
            ],
        ])->where('slug', $slug)->first();

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        // return page inertia /companies/$company->slug
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $company = Company::where('slug', $slug)->first();

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        // return page inertia /companies/$company->slug/edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|min:2|max:255',
            'address' => 'required|string',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'slug' => 'required|string|alpha_dash:ascii|min:4|max:42|unique:companies',
            'primary_color' => 'required|hex_color',
            'secondary_color' => 'required|hex_color',
            'logo_url' => 'required|image',
            'anonymous' => 'required|boolean',
        ]);

        $company = Company::where('slug', $slug)->first();

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::where('slug', $slug)->first();

        if (! $company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $company->deleteOrFail();

        // return page inertia /companies
    }
}
