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

    public function store(Request $request)
    {
        //console.log($request->recipeId);
        //dd($request);

        //dd($request->recipeId);
        //$recipeId = "hi";
        /*
        Recipes::create([
            'recipeId' => "5",
            'user_id' => "5",
        ]);
        */

        $request->user()->recipes()->create([
            'recipeId' => $request->recipeId
        ]);

        //$request->user()->recipes()->create($request->only('recipeId' => $request->recipeId));
        //dd('Wir haben einen Post');
        //return back();
    }
}
