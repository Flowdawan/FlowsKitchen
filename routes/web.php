<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TasksController::class, 'index']);

Route::view('shops', 'layout');

Route::resource('tasks', TasksController::class);


Route::get('about', function() {
    return "It's all about php";
});

Route::get('users', function()
{
    return View::make('users');
});

Route::get('users/{id}', function($id)
{
    if($id == 1){
        return View::make('welcome');
    }else{
        return "servus";
    }
}) -> name('hello.show');

/*
Route::middleware('auth')->group(function() {
    Route::get('dashboard', function () {
        return view('dashboard');
    });
    Route::get('account', function () {
        return view('account');
    });
});*/



Route::fallback(function(){
    return 'Oh no crap - this site doesn\'t exist';
});
