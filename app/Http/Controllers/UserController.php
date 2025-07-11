<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function displayRegistrationForm()
    {
        return view('register');
    }

    public function create(Request $request)
    {
        //validate the form input
        $request->validate([
            'username' => 'required|string|min:4|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        $newUser = new User();

        $newUser->username = $request->username;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        $newUser->save();

        return redirect('/my-dada-shakespeare');
    }

    public function displayUserArea()
    {
        return view('my-dada-shakespeare');
    }
}
