@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div id="app">
        <ingredients></ingredients>
        <meals></meals>
        <h1 id="bladeMealDb" name="bookmarkedMeal">@{{mealId}}</h1>
    </div>

    <script>

    </script>
@endsection

