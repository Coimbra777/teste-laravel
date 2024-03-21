<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactViewController;



Route::get('/', [ContactViewController::class, 'index']);


// Route::get('/', function () {
//     return view('welcome');
// });
