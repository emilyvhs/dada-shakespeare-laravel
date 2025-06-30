<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function displayDadaForm()
    {
        //retrieve all works
        $works = Work::all();

        //retrieve all characters
        $characters = DB::table('Characters')
            //exclude CharNames that refer to groups of already listed characters/stage directions
            ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
            ->get();

        return view('home', [
            'works' => $works,
            'characters' => $characters,
        ]);
    }
}
