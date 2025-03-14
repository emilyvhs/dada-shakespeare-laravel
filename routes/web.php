<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home']);

Route::get('/plays', [WorkController::class, 'allPlays']);
Route::get('/plays/{work:WorkID}', [WorkController::class, 'find']);
