<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Flow's Kitchen</title>
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end mb-2 mw-100">
    <a class="navbar-brand" href="{{route('index.show')}}">Flow's Kitchen</a>
    <ul class="navbar-nav mr-auto">
        <li>
            <a class="nav-link" href="{{route('index.show')}}">Home</a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo route('recipes.show')?>">Recipes</a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo route('abouts.show')?>">About us</a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto ">
        <!-- if (auth->users) or with auth and guest directive from blade and laravel-->

        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{route('index.show')}}">Florian Müllner</a>
            </li>
            <li class="nav-item">
                <!-- Because of xss protection we use here a form for the logout, if not someone could logout somebody else-->
                <form action="{{route('logouts.show')}}" method="post">
                    @csrf
                    <button class="nav-link btn" type="submit">Logout</button>
                </form>
            </li>
        @endauth

        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{route('logins.show')}}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('registers.show')}}">Register</a>
            </li>
        @endguest

        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </ul>
</nav>
@yield('content')

<footer class="bg-light text-center mw-100 container-fluid fixed-bottom">
    <!-- Copyright -->
    <div class="p-3">
        © 2020 Copyright:
        <a class="text-dark" href="/">Flow's kitchen</a>
    </div>
    <!-- Copyright -->
</footer>
</body>
</html>
