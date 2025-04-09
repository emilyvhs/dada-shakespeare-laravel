<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;
use Illuminate\Http\JsonResponse;

class ParagraphApiController extends Controller
{
    public function all(): JsonResponse
    {
        $paragraphs = Paragraph::all();

        return response()->json([
            'message' => 'Found all paragraphs',
            'data' => $paragraphs,
        ]);
    }

    public function find(Paragraph $paragraph): JsonResponse
    {
        return response()->json([
            'message' => 'Found single paragraph',
            'data' => $paragraph,
        ]);
    }
}
