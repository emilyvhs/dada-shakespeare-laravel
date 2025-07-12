<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        //set username in session
//        $username = $request->username;
//        session(['username' => $username]);

        //create new user
        $newUser = new User();

        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;

        //save new user
        $newUser->save();

        return redirect('/my-dada-shakespeare');
    }

    public function displayLoginForm(Request $request)
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        //validate the form input and save as $credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            //if authentication is successful, regenerate session to prevent session fixation
            $request->session()->regenerate();

            //redirect to user area
            return redirect('/my-dada-shakespeare');
        }

        //if authentication is unsuccessful, return back with errors
        return back()->withErrors([
            'email' => 'Incorrect log in information! Please try again',
        ])->onlyInput('email');
    }

    public function displayUserArea()
    {
        //pass authenticated user's username
        $user = Auth::user();
        $name = $user->name;

        return view('my-dada-shakespeare', [
            'name' => $name,
        ]);
    }
}
