<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function displayDadaForm()
    {
        $works = Work::all();

        return view('home', [
            'works' => $works,
        ]);
    }
}
