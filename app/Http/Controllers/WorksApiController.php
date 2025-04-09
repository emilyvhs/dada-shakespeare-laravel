<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\JsonResponse;

class WorksApiController extends Controller
{
    public function all(): JsonResponse
    {
        $works = Work::all()
            ->where('GenreType', '!=', 'p')
            ->where('GenreType', '!=', 's');

        return response()->json([
            'message' => 'Found all works',
            'data' => $works,
        ]);
    }

    public function find(Work $work): JsonResponse
    {
        return response()->json([
            'message' => 'Found single work',
            'data' => $work,
        ]);
    }
}
