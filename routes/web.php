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


Route::view('/', 'content.index');

Route::view('recipes', 'content.recipes')->name('recipes.show');

Route::view('about', 'content.about')->name('abouts.show');


/*
 * Testing routes
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
