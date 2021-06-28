@extends('layouts.app')
@section('title', 'Home')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="app">
        <ingredients></ingredients>
        <meals></meals>
        <h1 id="bladeMealDb" name="bookmarkedMeal">@{{mealId}}</h1>
    </div>

    <script>

    </script>
@endsection

