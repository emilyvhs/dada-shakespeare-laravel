<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultsController;
use Illuminate\Support\Facades\Route;

//display homepage and Dada form
Route::get('/', [HomeController::class, 'displayDadaForm']);

//display results
Route::post('/results', [ResultsController::class, 'display']);

//get all works
//get single work

//get all chapters for specified work
//get single chapter

//get all characters for specified work
//get single character

//get all paragraphs for specified work
//get all paragraphs for specified character
//shuffle all paragraphs for specified work
//shuffle all paragraphs for
