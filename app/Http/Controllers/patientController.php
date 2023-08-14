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
    function showLogin(){
        return view('component.login');
    }
    function userData(){
        return view('component.userData');
    }
    // ------------------------------------
    // sign up function
    // ------------------------------------
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
        $image = $request->image;
		// store user data in database
		DB::insert(
			'insert into users(first_name, last_name, email , phone, password, image) values(?,?,?,?,?,?)',
			[
				$first_name,
				$last_name,
				$email,
				$phone,
				$password,
                $image,
			]
		);
		// get data from database --> to use it in sessions.
		$userId = DB::getPdo()->lastInsertId();
		$result = DB::select('select first_name, last_name, email, phone from users where id = ? ', [$userId]);
		$user = $result[0];

		// using Sessions
		if ($user == null) {
            return back()->with(['error'=>'Problem in your registiration'])->withInput();
		}
        session()->regenerate();
		session([
			'loggedIn' => true,
			'userId' => $userId,
			'user' => $user,
		]);
		return redirect('/dashboard')->withSuccess('You Register Succussfully');
	}
    // ---------------------------------------
    // login function
    // ---------------------------------------
    function login(Request $request){
        $email = $request->email ;
        $password = $request->password ;

        $request->validate([
            'email' => 'required|email',
            'password'=> 'required',
        ]);
        // search for the user.
        $result = DB::select('select * from users where email = ?',[$email]);
        if(!$result){
            return back()->with(['error'=>'this email is not found'])->withInput();
        }else{
            $user = $result[0];
            if(!Hash::check($password,$user->password)){
                return back()->with(['error'=>'Inncorrect Password']);
            }else{
                session()->regenerate();
                session([
                    'loggedIn' => true,
                    'userId' => $user->id,
                    'user' => $user,
                ]);
                return redirect('/dashboard')->withSuccess('You are Loged In Now..!');
            }
        }

        return dd($request->all());
    }
    // ---------------------------------------------
    // logout function
    // ---------------------------------------------
    function logout(){
        session()->invalidate();
        return redirect('/');
    }
}
