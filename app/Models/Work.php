<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $hidden = ['Notes', 'ShortTitle', 'GenreType', 'Source'];
}
