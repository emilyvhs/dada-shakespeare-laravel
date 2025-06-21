<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\JsonResponse;

class WorkApiController extends Controller
{
    public function all(): JsonResponse
    {
        $works = Work::all();

        if(!$works) {
            return response()->json([
                'message' => 'No works found'
            ], 404);
        }

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
