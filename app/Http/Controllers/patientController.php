<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        // Validation rules
        $request->validate([
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            // Add 'phone' validation if needed
        ]);

        // User data
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phone = $request->phone; // Make sure you have 'phone' field in your form
        $password = Hash::make($request->password);

        // Store user data in the database
        $userId = DB::table('users')->insertGetId([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone, // Make sure you have 'phone' column in your users table
            'password' => $password,
        ]);

        // Using Sessions
        $user = DB::table('users')->where('id', $userId)->first();
        if ($user == null) {
            return back()->with(['error' => 'Unexpected error happened during registration'])->withInput();
        }

        session([
            'loggedIn' => true,
            'userId' => $userId,
        ]);

        return redirect('/dashboard');
    }

}
