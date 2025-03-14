<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function all()
    {
        $chapters = Chapter::all()
        ->where('WorkID', '!=', 'loverscomplaint')
        ->where('WorkID', '!=', 'passionatepilgrim')
        ->where('WorkID', '!=', 'phoenixturtle')
        ->where('WorkID', '!=', 'rapelucrece')
        ->where('WorkID', '!=', 'sonnets')
        ->where('WorkID', '!=', 'venusadonis');

        return $chapters;
    }
}
