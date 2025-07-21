<?php

namespace App\Http\Controllers;

use App\Models\SavedDada;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SavedDadaApiController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'paragraphs' => 'required|array'
        ]);

        $paragraphIdString = Arr::join($request->paragraphs, ',');

        $newSavedDada = new SavedDada();

        $newSavedDada->user_id = $request->user_id;
        $newSavedDada->paragraphs = $paragraphIdString;

        $newSavedDada->save();

        return response()->json([
            'message' => 'Dada saved',
            'data' => $newSavedDada
        ]);
    }
}
