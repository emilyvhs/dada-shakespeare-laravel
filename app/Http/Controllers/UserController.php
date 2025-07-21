<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'name' => 'required|string|min:4|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        //create new user
        $newUser = new User();

        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        //save new user
        $newUser->save();

        //set name in session
        $name = $newUser->name;
        session(['name' => $name]);

        return redirect('/my-dada-shakespeare');
    }

    public function displayLoginForm(Request $request)
    {
        return view('login');
    }

    public function login(Request $request)
    {
        //validate the form input
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);

        $email = $request->email;

        //database query to retrieve name
        $name = DB::table('users')
            ->where('email', '=', $email)
            ->value('name');

        //set name in session
        session(['name' => $name]);

        //redirect to user area
        return redirect('/my-dada-shakespeare');
    }

    public function displayUserArea()
    {
        if (session('name')) {
            return view('my-dada-shakespeare');
        }

        return view('login');

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
