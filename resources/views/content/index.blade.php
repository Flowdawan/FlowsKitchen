@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div id="app">
        <ingredients></ingredients>
        <meals></meals>
    </div>

    <script>
        window.auth_user = "notLoggedIn";
    </script>
    @auth()
        <script>
            window.auth_user = "LoggedIn";
        </script>
    @endauth


@endsection

