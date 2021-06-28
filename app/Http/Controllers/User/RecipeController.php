<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Recipes;
use Illuminate\Http\Request;

class RecipeController extends Controller
{

    public function show()
    {
        $recipes = Recipes::get();
        return view('content.recipes', [
            'recipes' => $recipes
        ]);
    }

    public function store(Request $request){

        dd($request);

        $request->user()->recipes()->create($request->only('recipeId'));
        //dd('Wir haben einen Post');
        //return back();
    }
}
