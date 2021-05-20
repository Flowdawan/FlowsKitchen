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
<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end mb-2">
    <a class="navbar-brand" href="#">Flow's Kitchen</a>
    <ul class="navbar-nav mr-auto">
        <li>
            <a class="nav-link" href="/">Home</a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo route('recipes.show')?>">Rezepte</a>
        </li>
        <li>
            <a class="nav-link" href="<?php echo route('abouts.show')?>">Über uns</a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto ">
        <li class="nav-item">
            <a class="nav-link" href="#">Florian Müllner</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../auth/login">Anmelden</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../auth/register">Registrieren</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../auth/logout">Abmelden</a>
        </li>
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
