<?php

namespace App\Http\Controllers;

use App\Models\Paragraph;

class ParagraphController extends Controller
{
    public function all()
    {
        $paragraphs = Paragraph::all()
            ->where('WorkID', '!=', 'loverscomplaint')
            ->where('WorkID', '!=', 'passionatepilgrim')
            ->where('WorkID', '!=', 'phoenixturtle')
            ->where('WorkID', '!=', 'rapelucrece')
            ->where('WorkID', '!=', 'sonnets')
            ->where('WorkID', '!=', 'venusadonis');

        return $paragraphs;
    }
}
