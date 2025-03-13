<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function allPlays()
    {
        $works = Work::all()
            ->where('GenreType', '!=', 'p')
            ->where('GenreType', '!=', 's');

        return view('plays', [
            'works' => $works
        ]);
    }

    public function find(Work $work)
    {
        return view('singlePlay', [
            'work' => $work
        ]);
    }
}
