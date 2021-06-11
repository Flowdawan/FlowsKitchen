<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{

    public function index(){
        return view('auth.login');
    }

    public function logoutUser(Request $request){

        //loggt das 'user'-objekt aus
        auth()->logout();

        return redirect()->route('index.show');


    }
}
