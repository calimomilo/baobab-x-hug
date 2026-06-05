<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;

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
        ]);

        $contact = ContactForm::create([
            'company_name' => $validated['company_name'],
            'address' => $validated['address'],
            'contact_address' => $validated['contact_address'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // return page inertia /contacts/$contact->id
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
