<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{

    public function index()
    {
        
        $contacts = Contact::all();
        return response()->json(['data' => $contacts], 201);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|numeric'
        ]);

        return Contact::create($validatedData);
    }

    public function show(string $id)
    {
        return Contact::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'required|numeric',
        ]);

        $contact->update($validatedData);

        return $contact;
    }


    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
