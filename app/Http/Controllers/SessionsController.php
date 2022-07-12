<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        //validate the request
        $attributes = request()->validate([
            //'email'=> 'required|exists:users,email', //this can rise a security problem
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //attempt to authenticate and log in the user based on the provided credentials
        if (!auth()->attempt($attributes)) {
            //auth failed:
            // return back()->withErrors(['email'=>'your provided credentials could not be verified.']);
            throw ValidationException::withMessages([
                'email' => 'your provided credentials could not be verified.'
            ]);
        }
        //session fixation , a security problem
        session()->regenerate();
        //redirect with a success flash message
        return redirect('/')->with('success', 'Welcome back!');
    }

    public function destroy()
    {
        //dd('log the user out');
        auth()->logout();
        return redirect('/')->with('success', 'Goodbye!');
    }
}
