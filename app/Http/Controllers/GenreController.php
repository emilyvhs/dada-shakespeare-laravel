<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

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
