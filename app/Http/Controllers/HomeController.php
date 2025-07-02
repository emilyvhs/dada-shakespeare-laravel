<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function displayDadaForm(Request $request)
    {
        header('Cache-Control: no-store');

        //retrieve all works
        $works = Work::all();

        //retrieve firstPlay from session
        if ($request->session()->has('firstPlay')) {
            $firstPlay = $request->session()->pull('firstPlay');
            $firstPlayCharacters = DB::table('Characters')
                ->where('Works', 'LIKE', "%$firstPlay")
                //exclude CharNames that refer to groups of already listed characters/stage directions
                ->whereNotIn('CharName', ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)'])
                ->get();
        } else {
            $firstPlayCharacters = [];
        }


        return view('home', [
            'works' => $works,
            'firstPlayCharacters' => $firstPlayCharacters,
        ]);
    }
}
