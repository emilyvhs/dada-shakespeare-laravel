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

        //retrieve character list for selected play
        $characters = DB::table('Characters')
            ->where('Works', 'LIKE', "%$WorkID%")
            //exclude any characters who do not speak
            ->where('SpeechCount', '>', 0)
            //exclude CharNames that refer to groups of already listed characters/stage directions
            ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
            ->orderBy('SpeechCount', 'desc')
            ->get();

        //retrieve and shuffle all paragraphs for selected play, joining with Characters table
        $shuffledParagraphList = DB::table('Paragraphs')
            ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
            ->where('WorkID', '=', $WorkID)
            ->inRandomOrder()
            ->get();

        return view('results', [
            'title' => $title,
            'shuffledParagraphs' => $shuffledParagraphList,
            'characters' => $characters,
        ]);
    }
}
