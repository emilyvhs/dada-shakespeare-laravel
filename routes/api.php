<?php

use App\Http\Controllers\WorksApiController;
use Illuminate\Support\Facades\Route;

Route::get('/works', [WorksApiController::class, 'all']);
