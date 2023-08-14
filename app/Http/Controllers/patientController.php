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
		// validation rules
		$request->validate([
			'first_name' => 'required|max:100',
			'last_name' => 'required|max:100',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed|',
		]);
		// user data

		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$phone = $request->phone;
		$password = Hash::make($request->password);

		// store user data in database

		DB::insert(
			'insert into users(first_name, last_name, email , phone, password) values(?,?,?,?,?)',
			[
				$first_name,
				$last_name,
				$email,
				$phone,
				$password
			]
		);

		// get data from database --> to use it in sessions.

		$userId = DB::getPdo()->lastInsertId();
		$result = DB::select('select first_name, last_name, email, phone from users where id = ? ', [$userId]);
		$user = $result[0];

		// using Sessions
		if ($user == null) {
            return back()->with('errors', $user->messages()->all()[0])->withInput();
		}
		session([
			'loggedIn' => true,
			'userId' => $userId,
			'user' => $user,
		]);
		return redirect('/dashboard')->withSuccess('You Register Succussfully');
	}
}
