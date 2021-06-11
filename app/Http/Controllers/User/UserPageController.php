<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    //if someone want to call the 'profile' page in the url he get's to this controller and the controller checks if the user is
    //logged in, if not the user get's to the login page, if yes then the 'show'-function is called
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        //$user = auth()->user();
        return view('user.userpage');
    }
}

