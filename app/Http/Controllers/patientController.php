<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class patientController extends Controller
{
    function home()
    {
        return view('pages.home');
    }
    function dashbord()
    {
        return view('pages.dashboard');
    }
    function showSignUp()
    {
        return view('component.signup');
    }
    function signUp(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email|',
            'password' => 'required|confirmed|min:8',
        ]);
        return  dd($request->all());
    }
}
