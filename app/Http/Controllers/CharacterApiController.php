<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Work;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

    public function selectedPlay(string $WorkID): JsonResponse
    {
        $characterList = DB::table('Characters')
        ->where('Works', '=', $WorkID)->get();

        return response()->json([
            'message' => 'Found all characters for selected play',
            'data' => $characterList,
        ]);
    }
}
