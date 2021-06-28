<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    //this method get's called when someone clicks on the delete button, or exactly use the delete method on the profile page
    //The 'User' class from laravel have a function delete, we search for the user with the id and then delete it
    //IMPORTANT is to us ->onDelete('cascade') by all connected data (example saved recipes) foreign keys
    public function delete(){
        User::find(auth()->user()->id)->delete();
        return redirect()->route('index.show');
        //dd('Dein Account wurde gelöscht!');
    }

    public function put(Request $request){
        if(auth()->user()->email == $request->email){
            $this->validate($request, [
                'name' => 'required|max:100',
                'password' => 'required|confirmed'
            ]);
        }else{
            $this->validate($request, [
                'name' => 'required|max:100',
                'email' => 'required|email|unique:users,email|max:120',
                'password' => 'required|confirmed'
            ]);
        }
        //dd($request->request);
        DB::table('users')
            ->where('id', auth()->user()->id)
            ->update(array('name' => $request->name,'email' => $request->email, 'password' => Hash::make($request->password)));

        //update users set name = ?,email=?,password=? where id = ?', [$request->name, $request->email, auth()->user()->id]);

        return redirect()->route('profiles.show');

    }
}

