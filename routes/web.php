<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\ChapterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home']);

Route::get('/plays', [WorkController::class, 'allPlays']);
Route::get('/plays/{work:WorkID}', [WorkController::class, 'find']);

Route::get('/chapters', [ChapterController::class, 'all']);

Route::get('/characters', [CharacterController::class, 'all']);
