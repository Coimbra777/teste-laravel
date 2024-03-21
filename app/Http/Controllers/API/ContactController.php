<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Contact::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,email',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        return Contact::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Contact::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $contact->update($validatedData);

        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
