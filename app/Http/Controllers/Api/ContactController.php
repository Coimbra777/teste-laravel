<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
  
    public function index()
    {
       $contacts = Contact::all(); 
        return Inertia::render('Contact', ['contacts' => $contacts]); 
    }

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
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $contact->update($validatedData);

        return $contact;
    }

  
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(null, 204);
    }
}
