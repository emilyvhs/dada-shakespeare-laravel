<?php

namespace App\Http\Controllers;

use App\Models\SavedDada;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        //database query with relations to retrieve this user's saved dadas
        $savedDadaWithRelations = SavedDada::with(['first_play_title', 'second_play_title', 'remove_character_name', 'add_character_name'])
            ->find($savedDada);

        return view('/saved-dadas', [
            'savedDada' => $savedDadaWithRelations
        ]);
    }
}
