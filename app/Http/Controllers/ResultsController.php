<?php

namespace App\Http\Controllers;

use App\Models\SavedDada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ResultsController extends Controller
{
    public function display(Request $request)
    {
        //validate the form input
        $request->validate([
            'title' => 'required|string|exists:works,WorkID',
            'shuffle' => [
                'required',
                'string',
                Rule::in(['all', 'act', 'scene']),
            ],
            'removeCharacter' => 'nullable|string|exists:characters,CharID',
            'secondPlay' => 'nullable|string|exists:works,WorkID',
            'addCharacter' => 'nullable|string|exists:characters,CharID',
        ]);

        //set $WorkID
        $WorkID = $request->title;
        //set firstPlay value in session
        session(['firstPlay' => $WorkID]);

        //set $shuffle
        $shuffle = $request->shuffle;
        //set shuffle value in session
        session(['shuffle' => $shuffle]);

        //set $removedCharacter
        $removedCharacter = $request->removeCharacter;
        //set remove_character in session
        session(['remove_character' => $removedCharacter]);
        //set $removedCharacterName to the value of CharName in the Characters table
        $removedCharacterName = DB::table('characters')
            ->where('CharID', '=', $removedCharacter)
            ->value('CharName');

        //set $secondPlay
        $secondPlay = $request->secondPlay;
        //set secondPlay value in session
        session(['secondPlay' => $secondPlay]);
        //set $secondPlayTitle to the value of LongTitle in the Works table
        $secondPlayTitle = DB::table('works')
            ->where('WorkID', '=', $secondPlay)
            ->value('LongTitle');

        //set $addedCharacter
        $addedCharacter = $request->addCharacter;
        //set add_character in session
        session(['add_character' => $addedCharacter]);
        //set $addedCharacterName to the value of CharName in the Characters table
        $addedCharacterName = DB::table('characters')
            ->where('CharID', '=', $addedCharacter)
            ->value('CharName');

        //set $title to the value of LongTitle in the Works table
        $title = DB::table('works')
            ->where('WorkID', '=', $WorkID)
            ->value('LongTitle');

        //retrieve character list for selected play
        $characters = DB::table('characters')
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
            $first = DB::table('paragraphs')
                ->leftJoin('characters', 'paragraphs.CharID', '=', 'characters.CharID')
                ->where('paragraphs.CharID', '=', $addedCharacter);

            //retrieve and shuffle all paragraphs for selected play, joining with Characters table
            $shuffledParagraphs = DB::table('paragraphs')

                ->leftJoin('characters', 'paragraphs.CharID', '=', 'characters.CharID')
                ->where('WorkID', '=', $WorkID)
                //exclude speeches for removedCharacter
                ->whereNot('paragraphs.CharID', '=', $removedCharacter)
                //union with query to retrieve speeches for addedCharacter
                ->union($first)
                ->inRandomOrder()
                ->get();
        }

        //if shuffling within each act...
        if($shuffle === 'act') {
            //add in speeches for addedCharacter
            $first = DB::table('paragraphs')
                ->leftJoin('characters', 'paragraphs.CharID', '=', 'characters.CharID')
                ->where('paragraphs.CharID', '=', $addedCharacter);

            //retrieve and shuffle all paragraphs for selected play, joining with Characters table
            $shuffledParagraphs = DB::table('paragraphs')
                ->leftJoin('characters', 'paragraphs.CharID', '=', 'characters.CharID')
                ->where('WorkID', '=', $WorkID)
                //exclude speeches for removedCharacter
                ->whereNot('paragraphs.CharID', '=', $removedCharacter)
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
            $first = DB::table('paragraphs')
                ->leftJoin('characters', 'paragraphs.CharID', '=', 'characters.CharID')
                ->where('paragraphs.CharID', '=', $addedCharacter);

            $shuffledParagraphs = DB::table('paragraphs')
                //retrieve and shuffle all paragraphs for selected play, joining with Characters table
                ->leftJoin('characters', 'paragraphs.CharID', '=', 'characters.CharID')
                ->where('WorkID', '=', $WorkID)
                //exclude speeches for removedCharacter
                ->whereNot('paragraphs.CharID', '=', $removedCharacter)
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
            'secondPlayTitle' => $secondPlayTitle,
            'removedCharacterName' => $removedCharacterName,
            'addedCharacterName' => $addedCharacterName,
        ]);
    }
}
