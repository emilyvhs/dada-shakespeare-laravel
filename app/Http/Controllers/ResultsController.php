<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function display(Request $request)
    {
        //validate the form input
        $request->validate([
            'title' => 'required|string|exists:Works,LongTitle'
        ]);

        //set $title to the value of LongTitle in the Works table
        $title = $request->title;

        //set $WorkID
        $WorkID = DB::table('Works')
            ->where('LongTitle', '=', $title)
            ->value('WorkID');

        //retrieve and shuffle all paragraphs for selected play, joining with Characters table
        $shuffledParagraphList = DB::table('Paragraphs')
            ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
            ->where('WorkID', '=', $WorkID)
            ->inRandomOrder()
            ->get();

        return view('results', [
            'title' => $title,
            'shuffledParagraphs' => $shuffledParagraphList
        ]);
    }
}
