<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {

        // validation the $request object gives information about the submitted data (dd($request->email);)
        //and the validate method comes with laravel and defined rules which we can just use
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email|max:120',
            'password' => 'required|confirmed'
        ]);

        //store the User in the database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        //sign the User in
        //we use here a 'auth helper' where we get the User object with he is logged in or null if not
        auth()->attempt($request->only('email', 'password'));

        //redirect the User
        return redirect()->route('index.show');
    }
}
