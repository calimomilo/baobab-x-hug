<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ContactForm;
use App\Models\Season;
use App\Services\BloodLeagueScorer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the contact form.
     */
    public function index()
    {
        $contactForms = ContactForm::orderBy('created_at', 'desc')->get();

        // return page inertia
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return Inertia::render('Contact');
    }

    /**
     * Store a newly created resource in storage.
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
            'message' => 'nullable|string|max:1000',
        ]);

        $contact = ContactForm::create([
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
            'contact_address' => $validated['contact_address'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
        ]);

        // $collectIds = Season::where('status', 'open')->with('collects')->first()->collects->pluck('company_id');
        // $companies = Company::whereIn('id', $collectIds)->get();
        // $companies->map(function ($company) {
        //     $label = app(BloodLeagueScorer::class)->computeLabel($company->id, 2);
        //     $company->label = [
        //         'name' => $label->name(),
        //         'slug' => $label,
        //     ];
        // });

        // $base = $companies->where('anonymous', '=', 0)->select(['company_name', 'logo_url', 'label']);

        return to_route('home')->with('toast', [
            'success' => $contact->exists,
            'message' => $contact->exists ? 'Votre formulaire a été envoyé avec succès !' : 'Il y a eu une erreur avec l\'envoi de votre formulaire.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = ContactForm::findOrFail($id);

        // return page inertia /contacts/$contact->id
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = ContactForm::findOrFail($id);

        $contact->deleteOrFail();

        // return page inertia /contacts
    }
}
