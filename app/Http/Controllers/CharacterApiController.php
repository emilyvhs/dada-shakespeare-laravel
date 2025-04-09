<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\JsonResponse;

class CharacterApiController extends Controller
{
    public function all(): JsonResponse
    {
        $characters = Character::all();

        return response()->json([
            'message' => 'Found all characters',
            'data' => $characters,
        ]);
    }

    public function find(Character $character): JsonResponse
    {
        return response()->json([
            'message' => 'Found single character',
            'data' => $character,
        ]);
    }
}
