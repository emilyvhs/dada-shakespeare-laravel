<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ParagraphApiController extends Controller
{
    public function all(): JsonResponse
    {
        $paragraphs = Paragraph::all();

        if(!$paragraphs) {
            return response()->json([
                'message' => 'No paragraphs found'
            ], 404);
        }

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
            ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
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

    public function selectedCharacter(string $CharID): JsonResponse
    {
        $paragraphList = DB::table('Paragraphs')
            ->where('CharID', '=', $CharID)
            ->orderBy('ParagraphNum')
            ->get();

        if(count($paragraphList) === 0) {
            return response()->json([
                'message' => 'Character not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Found all paragraphs for selected character',
            'data' => $paragraphList,
        ]);
    }

    public function shuffleSelectedPlay(string $WorkID): JsonResponse
    {
        $shuffledParagraphList = DB::table('Paragraphs')
            ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
            ->where('WorkID', '=', $WorkID)
            ->inRandomOrder()
            ->get();

        if(count($shuffledParagraphList) === 0) {
            return response()->json([
                'message' => 'Play not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Shuffled all paragraphs for selected play',
            'data' => $shuffledParagraphList
        ]);
    }

    public function shuffleSelectedCharacter(string $CharID): JsonResponse
    {
        $shuffledParagraphList = DB::table('Paragraphs')
            ->where('CharID', '=', $CharID)
            ->inRandomOrder()
            ->get();

        if(count($shuffledParagraphList) === 0) {
            return response()->json([
                'message' => 'Character not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Shuffled all paragraphs for selected character',
            'data' => $shuffledParagraphList
        ]);
    }
}
