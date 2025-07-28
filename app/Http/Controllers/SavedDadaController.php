<?php

namespace App\Http\Controllers;

use App\Models\SavedDada;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SavedDadaController extends Controller
{
    public function create()
    {
        //check there's a user logged into the session and redirect if not
        if (!session('name')) {
            return redirect('/login');
        }

        //implode array of paragraph ids into a string
        $paragraphIdString = session('paragraph_ids')->implode(',');

        //instantiate SavedDada model
        $newSavedDada = new SavedDada();

        //populate newSaved Dada with info from session
        $newSavedDada->user_id = session('user_id');
        $newSavedDada->first_play = session('firstPlay');
        $newSavedDada->shuffle = session('shuffle');
        $newSavedDada->paragraphs = $paragraphIdString;
        $newSavedDada->remove_character = session('remove_character');
        $newSavedDada->second_play = session('secondPlay');
        $newSavedDada->add_character = session('add_character');

        $newSavedDada->save();

        return redirect('/my-dada-shakespeare');
    }

    public function find(SavedDada $savedDada)
    {
        //create an array from the string of paragraph ids
        $paragraphIdArray = Str::of($savedDada->paragraphs)->explode(',')->toArray();

        //use array and join Characters table to retrieve paragraphs
        $shuffledParagraphs = [];
        foreach($paragraphIdArray as $paragraphId) {
            $paragraph = DB::table('Paragraphs')
                ->leftJoin('Characters', 'Paragraphs.CharID', '=', 'Characters.CharID')

                ->where('ParagraphID', '=', $paragraphId)
                ->first();
            array_push($shuffledParagraphs, $paragraph);
        }

        //set $savedDadaWorkID of first_play
        $savedDadaWorkID = $savedDada->first_play;
        //set $title to LongTitle of play by WorkID
        $title = DB::table('Works')
            ->where('WorkID', '=', $savedDadaWorkID)
            ->value('LongTitle');

        //set $shuffle
        $shuffle = $savedDada->shuffle;

        //set $removedCharacter
        $removedCharacter = $savedDada->remove_character;

        //set $addedCharacter
        $addedCharacter = $savedDada->add_character;

        //retrieve character list
        $characters = DB::table('Characters')
            ->where('Works', 'LIKE', "%$savedDadaWorkID%")
            //exclude characters who do not speak
            ->where('SpeechCount', '!=', 0)
            //exclude CharNames that refer to groups of already listed characters/stage directions
            ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
            //exclude removedCharacter
            ->whereNot('CharID', '=', $removedCharacter)
            //include addedCharacter
            ->orWhere('CharID', '=', $addedCharacter)
            ->get();

        return view('/saved-dadas', [
            'title' => $title,
            'characters' => $characters,
            'shuffle' => $shuffle,
            'shuffledParagraphs' => $shuffledParagraphs,
        ]);
    }
}
