@extends('layouts.app')

@section('content')

    <h1 class="text-center text-white">Here you can see your favorite Recipes</h1>

    <form action="{{route('recipes.show')}}" method="POST">
        @csrf
        <input id="recipeId" type="text"
                name="recipeId"
               value="" autofocus>

        <button class="btn-danger text-black-50" type="submit"
                id="post_something">Post
            Account
        </button>
    </form>

    <!--- To check with there are any posts, if yes iterate throw and show --->
    @if($recipes->count())
        <!--- api call einbauen --->

    @else
        <p class="text-center text-white">There are no saved recipes</p>
    @endif
@endsection
