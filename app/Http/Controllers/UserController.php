<?php

namespace App\Http\Controllers;

use App\Models\SavedDada;
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

        //database query to retrieve id
        $user_id = DB::table('users')
            ->where('email', '=', $email)
            ->value('id');

        //set user_id in session
        session(['user_id' => $user_id]);

        //redirect to user area
        return redirect('/my-dada-shakespeare');
    }

    public function displayUserArea()
    {
        if (!session('name')) {
            return redirect('/login');
        }

        //retrieve user_id from session
        $user_id = session('user_id');
        //database query to retrieve user info
        $user = DB::table('users')
            ->where('id', '=', $user_id)
            ->get();

        //database query with relations to retrieve this user's saved dadas
        $savedDadas = SavedDada::with(['first_play_title', 'second_play_title', 'remove_character_name', 'add_character_name'])
            ->where('user_id', '=', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('my-dada-shakespeare', [
            'savedDadas' => $savedDadas,
            'user' => $user,
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
