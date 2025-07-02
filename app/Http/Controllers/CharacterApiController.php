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

        if(!$characters) {
            return response()->json([
                'message' => 'No characters found'
            ], 404);
        }

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
            ->where('Works', 'LIKE', "%$WorkID%")
            ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
            ->get();

        if(count($characterList) === 0) {
            return response()->json([
                'message' => 'Play not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Found all characters for selected play',
            'data' => $characterList,
        ]);
    }
}
