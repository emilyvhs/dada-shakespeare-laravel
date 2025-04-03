<?php

namespace App\Http\Controllers;

use App\Models\Character;

class CharacterController extends Controller
{
    public function all()
    {
        $characters = Character::all();

        return $characters;
    }
}
