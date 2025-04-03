<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\JsonResponse;

class WorksApiController extends Controller
{
    public function all(): JsonResponse
    {
        $works = Work::all();

        return response()->json([
            'message' => 'Found all works',
            'data' => $works,
        ]);
    }
}
