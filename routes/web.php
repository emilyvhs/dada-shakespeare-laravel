<?php

use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WorkController::class, 'home']);
Route::get('/plays', [WorkController::class, 'allPlays']);
Route::get('/plays/{WorkID}', [WorkController::class, 'find']);
