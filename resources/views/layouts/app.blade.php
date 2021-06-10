<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>Flow's Kitchen</title>
    <link rel="shortcut icon" type="image/png" href="{{url('/images/logov.png')}}"/>
</head>
<body class="bg-dark">
<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end mb-2 mw-100">
    <!--- hi !--->
    <a class="navbar-brand" href="{{route('index.show')}}">Flow's Kitchen
        <img src="{{url('/images/logov.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse align-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class="nav-link" href="{{route('index.show')}}">Home</a>
                </li>
                <li>
                    <a class="nav-link" href="<?php echo route('recipes.show')?>">Recipes</a>
                </li>
                <li>
                    <a class="nav-link" href="<?php echo route('abouts.show')?>">About</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto ">
                <!-- if (auth->users) or with auth and guest directive from blade and laravel-->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('index.show')}}">{{auth()->user()->name}}</a>
                    </li>
                    <li class="nav-item">
                        <!-- Because of xss protection we use here a form for the logout, if not someone could logout somebody else-->
                        <form action="{{route('logouts.show')}}" method="post">
                            @csrf
                            <button class="nav-link btn" type="submit">Sign out</button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('logins.show')}}">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('registers.show')}}">Sign up</a>
                    </li>
                @endguest
            </ul>
        </div>
</nav>
@yield('content')

<footer class="bg-light text-center mw-100 container-fluid fixed-bottom">
    <!-- Copyright -->
    <div class="p-3">
        © 2020 Copyright:
        <a class="text-dark" href="/">Flow's kitchen</a>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

</body>
</html>
