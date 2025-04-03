<?php

use App\Http\Controllers\ChapterApiController;
use App\Http\Controllers\WorksApiController;
use Illuminate\Support\Facades\Route;

Route::get('/works', [WorksApiController::class, 'all']);
Route::get('/works/{work:WorkID}', [WorksApiController::class, 'find']);

Route::get('/chapters', [ChapterApiController::class, 'all']);
Route::get('/chapters/{chapter:ChapterID}', [ChapterApiController::class, 'find']);
