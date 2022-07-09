<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            //'username' => 'required|min:3|max:255|unique:users,username',
            'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
            'email' => 'required|max:255|unique:users,email',  //pay attention not to have spaces
            'password' => ['required', 'min:8', 'max:255']
        ]);

        //dd('success validation succeeded');
       // $attributes['password'] = bcrypt($attributes['password']); //or we can set the attribute in the User Model
        User::create($attributes);
        return redirect('/');
    }
}
