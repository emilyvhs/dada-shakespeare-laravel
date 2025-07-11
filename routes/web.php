<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//display homepage and Dada form
Route::get('/', [HomeController::class, 'displayDadaForm']);

//display results
Route::post('/results', [ResultsController::class, 'display']);

//create a new user
Route::post('/register', [UserController::class, 'create']);
//display new user registration form
Route::get('/register', [UserController::class, 'displayRegistrationForm']);
//display logged in user area
Route::get('/my-dada-shakespeare', [UserController::class, 'displayUserArea']);
