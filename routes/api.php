<?php

use App\Http\Controllers\ChapterApiController;
use App\Http\Controllers\CharacterApiController;
use App\Http\Controllers\ParagraphApiController;
use App\Http\Controllers\WorksApiController;
use Illuminate\Support\Facades\Route;

Route::get('/works', [WorksApiController::class, 'all']);
Route::get('/works/{work:WorkID}', [WorksApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Work not found',
    ], 404);
});

Route::get('/chapters', [ChapterApiController::class, 'all']);
Route::get('/chapters/{chapter:ChapterID}', [ChapterApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Chapter not found',
    ], 404);
});

Route::get('/characters', [CharacterApiController::class, 'all']);
Route::get('/characters/{character:CharID}', [CharacterApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Character not found',
    ], 404);
});

Route::get('/characters/work/{WorkID}', [CharacterApiController::class, 'selectedPlay']);

Route::get('/paragraphs', [ParagraphApiController::class, 'all']);
Route::get('/paragraphs/{paragraph:ParagraphID}', [ParagraphApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Paragraph not found',
    ], 404);
});
