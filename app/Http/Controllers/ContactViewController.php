<?php

namespace App\Http\Controllers;
use Inertia\Inertia;


class ContactViewController extends Controller
{
    public function index(){
        return Inertia::render('Contact'); 
    }
}
