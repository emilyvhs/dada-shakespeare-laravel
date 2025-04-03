<?php

use App\Http\Controllers\WorksApiController;
use Illuminate\Support\Facades\Route;

Route::get('/works', [WorksApiController::class, 'all']);
Route::get('/works/{work:WorkID}', [WorksApiController::class, 'find']);
