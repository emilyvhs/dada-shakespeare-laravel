<?php

namespace App\Http\Controllers;

use App\Models\Work;

class WorkController extends Controller
{

    public function allPlays()
    {
        $works = Work::all()
            ->where('GenreType', '!=', 'p')
            ->where('GenreType', '!=', 's');

        return $works;
    }

    public function find(Work $work)
    {
        return $work;
    }
}
