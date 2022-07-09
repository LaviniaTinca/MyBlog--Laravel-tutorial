<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3',
            'email' => 'required|max:255',
            'password' => ['required', 'max:255', 'min:8']
        ]);

        //dd('success validation succeeded');
       // $attributes['password'] = bcrypt($attributes['password']); //or we can set the attribute in the User Model
        User::create($attributes);
        return redirect('/');
    }
}
