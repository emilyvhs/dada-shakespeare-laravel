<?php

use App\Http\Controllers\ChapterApiController;
use App\Http\Controllers\CharacterApiController;
use App\Http\Controllers\ParagraphApiController;
use App\Http\Controllers\WorkApiController;
use Illuminate\Support\Facades\Route;

//get all works
Route::get('/works', [WorkApiController::class, 'all']);
//get single work
Route::get('/works/{work:WorkID}', [WorkApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Work not found',
    ], 404);
});

//get all chapters
Route::get('/chapters', [ChapterApiController::class, 'all']);
//get single chapter
Route::get('/chapters/{chapter:ChapterID}', [ChapterApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Chapter not found',
    ], 404);
});

//get all characters
Route::get('/characters', [CharacterApiController::class, 'all']);
//get single character
Route::get('/characters/{character:CharID}', [CharacterApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Character not found',
    ], 404);
});
//get all characters for a specified work
Route::get('/characters/work/{WorkID}', [CharacterApiController::class, 'selectedPlay']);

//get all paragraphs
Route::get('/paragraphs', [ParagraphApiController::class, 'all']);
//get single paragraph
Route::get('/paragraphs/{paragraph:ParagraphID}', [ParagraphApiController::class, 'find'])->missing(function () {
    return response()->json([
        'message' => 'Paragraph not found',
    ], 404);
});
//get and randomly shuffle all paragraphs for a specified work
Route::get('/paragraphs/work/shuffle/{WorkID}', [ParagraphApiController::class, 'shuffleSelectedPlay']);
//get all paragraphs for a specified work (in original order)
Route::get('/paragraphs/work/{WorkID}', [ParagraphApiController::class, 'selectedPlay']);
//get and randomly shuffle all paragraphs for a specified work
Route::get('/paragraphs/character/shuffle/{CharID}', [ParagraphApiController::class, 'shuffleSelectedCharacter']);
//get all paragraphs for a specified character (in original order)
Route::get('/paragraphs/character/{character:CharID}', [ParagraphApiController::class, 'selectedCharacter']);
