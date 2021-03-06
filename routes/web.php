<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\RecipeController;
use App\Http\Controllers\User\UserPageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

/*
 *  :)
|--------------------------------------------------------------------------
| Web Routes :-*
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/', 'content.index')->name('index.show');

Route::view('about', 'content.about')->name('abouts.show');

Route::view('map', 'content.map')->name('maps.show');


//calls the register controller, one for the normal call and one for the post request after the submit button is clicked
// 'index' and 'store' are the methods to be called in the controller
Route::get('register', [RegisterController::class, 'index'])->name('registers.show');
Route::post('register', [RegisterController::class, 'store']);


Route::get('login', [LoginController::class, 'index'])->name('logins.show');
Route::post('login', [LoginController::class, 'loginUser']);

Route::post('logout', [LogoutController::class, 'logoutUser'])->name('logouts.show');

//routes for the profile page
Route::get('profile', [UserPageController::class, 'show'])->name('profiles.show');
Route::delete('profile', [UserPageController::class, 'delete']);
Route::put('profile', [UserPageController::class, 'put']);

//to show the saved recipes for an user
Route::get('recipes', [RecipeController::class, 'show'])->name('recipes.show');

Route::get('recipes/api', [RecipeController::class, 'api']);

Route::delete('recipes', [RecipeController::class, 'delete']);

Route::post('recipes', [RecipeController::class, 'store']);


//If the User goes to a site which doesnt exist we can define a fallback route
Route::fallback(function () {
    return view('content.404_page');
});

/*
 * Testing routes
 *
 *
Route::get('recipes/api', function(){
    return response()->json(auth()->user());
});
Route::get('/', [TasksController::class, 'index']);

Route::get('test', function(){
    return View::make('testview', ['name' => 'john']);
});

Route::get('/start', function(){
    return view('start', ['name' => 'tom', 'id' => 5]);
});

Route::view('shops', 'layout');

Route::resource('tasks', TasksController::class);

Route::view('/help', 'users');

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

Route::fallback(function(){
    return 'Oh no crap - this site doesn\'t exist';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

*/
