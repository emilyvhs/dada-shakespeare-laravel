<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ResultsController extends Controller
{
    public function display(Request $request)
    {
        //validate the form input
        $request->validate([
            'title' => 'required|string|exists:Works,WorkID',
            'shuffle' => [
                'required',
                'string',
                Rule::in(['all', 'act', 'scene']),
            ],
            'removeCharacter' => 'nullable|string|exists:Characters,CharID',
            'secondPlay' => 'nullable|string|exists:Works,WorkID',
            'addCharacter' => 'nullable|string|exists:Characters,CharID',
        ]);

        //set $WorkID
        $WorkID = $request->title;
        //set firstPlay value in session
        session(['firstPlay' => $WorkID]);

        //set $shuffle
        $shuffle = $request->shuffle;
        //set shuffle value in session
        session(['shuffle' => $shuffle]);

        //set removedCharacter
        $removedCharacter = $request->removeCharacter;
        //set remove_character in session
        session(['remove_character' => $removedCharacter]);

        //set SecondPlay
        $secondPlay = $request->secondPlay;
        //set secondPlay value in session
        session(['secondPlay' => $secondPlay]);

        //set addedCharacter
        $addedCharacter = $request->addCharacter;
        //set add_character in session
        session(['add_character' => $addedCharacter]);

        //set $title to the value of LongTitle in the Works table
        $title = DB::table('Works')
            ->where('WorkID', '=', $WorkID)
            ->value('LongTitle');

        //retrieve character list for selected play
        $characters = DB::table('Characters')
            ->where('Works', 'LIKE', "%$WorkID%")
            //exclude characters who do not speak
            ->where('SpeechCount', '!=', 0)
            //exclude CharNames that refer to groups of already listed characters/stage directions
            ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
            //exclude removedCharacter
            ->whereNot('CharID', '=', $removedCharacter)
            //include addedCharacter
            ->orWhere('CharID', '=', $addedCharacter)
            ->get();

        //if shuffling every line...
        if($shuffle === 'all'){
            //exclude speeches for removedCharacter

            //add in speeches for addedCharacter
            $first = DB::table('Paragraphs')
                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
                ->where('Paragraphs.CharID', '=', $addedCharacter);

            //retrieve and shuffle all paragraphs for selected play, joining with Characters table
            $shuffledParagraphs = DB::table('Paragraphs')

                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
                ->where('WorkID', '=', $WorkID)
                //exclude speeches for removedCharacter
                ->whereNot('Paragraphs.CharID', '=', $removedCharacter)
                //union with query to retrieve speeches for addedCharacter
                ->union($first)
                ->inRandomOrder()
                ->get();
        }

        //if shuffling within each act...
        if($shuffle === 'act') {
            //add in speeches for addedCharacter
            $first = DB::table('Paragraphs')
                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
                ->where('Paragraphs.CharID', '=', $addedCharacter);

            //retrieve and shuffle all paragraphs for selected play, joining with Characters table
            $shuffledParagraphs = DB::table('Paragraphs')
                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
                ->where('WorkID', '=', $WorkID)
                //exclude speeches for removedCharacter
                ->whereNot('Paragraphs.CharID', '=', $removedCharacter)
                //union with query to retrieve speeches for addedCharacter
                ->union($first)
                //order by acts
                ->orderBy('Section')
                ->inRandomOrder()
                ->get();
        }

        //if shuffling within each scene...
        if($shuffle === 'scene') {
            //add in speeches for addedCharacter
            $first = DB::table('Paragraphs')
                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
                ->where('Paragraphs.CharID', '=', $addedCharacter);

            $shuffledParagraphs = DB::table('Paragraphs')
                //retrieve and shuffle all paragraphs for selected play, joining with Characters table
                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')
                ->where('WorkID', '=', $WorkID)
                //exclude speeches for removedCharacter
                ->whereNot('Paragraphs.CharID', '=', $removedCharacter)
                //union with query to retrieve speeches for addedCharacter
                ->union($first)
                //order by acts
                ->orderBy('Section')
                //order by scenes
                ->orderBy( 'Chapter')
                ->inRandomOrder()
                ->get();
        }

        //set paragraph_ids in session
        session(['paragraph_ids' => $shuffledParagraphs->pluck('ParagraphID')]);

        return view('results', [
            'title' => $title,
            'shuffledParagraphs' => $shuffledParagraphs,
            'characters' => $characters,
            'shuffle' => $shuffle,
        ]);
    }
}
