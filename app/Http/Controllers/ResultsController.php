<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function display(Request $request)
    {
        $request->validate([
            'title' => 'required|string|exists:Works,LongTitle'
        ]);

        $title = $request->title;

        return view('results', [
            'title' => $title,
        ]);
    }
}
