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

        //set $savedDadaWithRelations
        $savedDadaWithRelations = SavedDada::with(['first_play_title', 'second_play_title', 'remove_character_name', 'add_character_name', 'user'])
            ->find($savedDada->id);

        //retrieve character list
        $characters = DB::table('Characters')
            ->where('Works', 'LIKE', "%$savedDada->first_play%")
            //exclude characters who do not speak
            ->where('SpeechCount', '!=', 0)
            //exclude CharNames that refer to groups of already listed characters/stage directions
            ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
            //exclude removedCharacter
            ->whereNot('CharID', '=', $savedDada->remove_character)
            //include addedCharacter
            ->orWhere('CharID', '=', $savedDada->add_character)
            ->get();

        return view('/saved-dadas', [
            'characters' => $characters,
            'shuffledParagraphs' => $shuffledParagraphs,
            'savedDada' => $savedDadaWithRelations,
        ]);
    }
}
