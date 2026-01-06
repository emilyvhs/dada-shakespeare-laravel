<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SavedDadaController;
use Illuminate\Support\Facades\Route;

//display homepage and Dada form
Route::get('/', [HomeController::class, 'displayDadaForm']);

//display results
Route::post('/results', [ResultsController::class, 'display']);

//save new dada
Route::post('/add', [SavedDadaController::class, 'create']);
//display selected saved dada
Route::get('/saved-dadas/{savedDada:id}', [SavedDadaController::class, 'find']);
