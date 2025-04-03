<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenreController extends Controller
{
    public function all()
    {
        $genres = Genre::all()
            ->where('GenreType', '!=', 'p')
            ->where('GenreType', '!=', 's');

        return $genres;
    }
}
