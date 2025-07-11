<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function displayRegistrationForm()
    {
        return view('register');
    }

    public function create(Request $request)
    {

    }

    public function displayUserArea()
    {
        return view('my-dada-shakespeare');
    }
}
