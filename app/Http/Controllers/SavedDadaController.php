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

        $paragraphIdString = Arr::join(session('paragraph_ids'), ',');

        $newSavedDada = new SavedDada();

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
}
