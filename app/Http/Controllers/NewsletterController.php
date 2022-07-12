<?php

namespace App\Http\Controllers;

use App\Services\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsletterController extends Controller
{
    public function __invoke(){
        //single action controller
        request()->validate(['email'=>'required|email']);  //we are validating what we receive

        try{
            $newsletter = new Newsletter(); // or we can send a newsletter as a parameter to the initial function
            $newsletter->subscribe(request('email'));

        }catch(\Exception $e){
            throw ValidationException::withMessages([
                'email'=>'This email could not be added to our newsletter list.'
            ]);

        }
        return redirect('/')
            ->with('success', 'You are now signed up for our newsletter!');
    }
}
