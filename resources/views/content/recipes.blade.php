@extends('layouts.app')

@section('content')
    <h1 class="text-center text-white">Here you can see your favorite Recipes</h1>
    <div id="app">
        <recipes></recipes>
    </div>
    <!--- To check with there are any posts, if yes iterate throw and show --->
    @if($recipes->count())
        @foreach($recipes as $recipe)
            <div class="mb-4 text-white text-center invisible">
                <p class="mb-2"> {{ $recipe  }} </p>
            </div>
        @endforeach
    @else
    @endif
@endsection
