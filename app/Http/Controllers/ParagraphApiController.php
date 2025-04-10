<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

    public function selectedPlay(string $WorkID): JsonResponse
    {
        $paragraphList = DB::table('Paragraphs')
            ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharName')
            ->where('WorkID', '=', $WorkID)
            ->orderBy('ParagraphNum')
            ->get();


        if(count($paragraphList) === 0) {
            return response()->json([
                'message' => 'Play not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Found all paragraphs for selected play',
            'data' => $paragraphList,
        ]);
    }
}
