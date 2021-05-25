<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function loginUser(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //attempt trys to login the user with the data we give, he checks correctly with the database connection setup
        if(!auth()->attempt($request->only('email', 'password'))){
            return back()->with('status', 'Invalid Credentials');
        }

        return redirect()->route('index.show');


    }
}
