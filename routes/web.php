<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

Route::get('/', [ContactController::class, 'index']);


// Route::get('/', function () {
//     return view('welcome');
// });
