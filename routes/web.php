<?php

use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/plays', [WorkController::class, 'allPlays']);
Route::get('/plays/{work:WorkID}', [WorkController::class, 'find']);
