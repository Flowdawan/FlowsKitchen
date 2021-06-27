@extends('layouts.app')
@section('title', '404')

@section('content')

    <h1 class="text-center text-white">404 - Here is nothing <br> You can go <a alt="404 Picture" href="{{route('index.show')}}">back</a> to our homepage </h1>

    <div class="content">
        <img src="/images/404_img.jpg"
             style="
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 80%; ">
    </div>

@endsection
