<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function display(Request $request)
    {
        $title = $request->work;

        return view('results', [
            'title' => $title,
        ]);
    }
}
