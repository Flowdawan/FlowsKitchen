@extends('layouts.app')
@section('title', 'About')

@section('content')
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
    <h2 id="about" class="text-center">We are a team of developers, who decided to build a new kitchen tool, which is there to help everyone to cook more at home. Since cooking at home is not only better for the environment, but also is helping to save some money. To build this tool, we used Laravel. Laravel is a web application framework with expressive, elegant syntax.</h2>
    <div class="content">
        <img src="/images/developer.svg"
             style="
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 50%; ">
    </div>


@endsection
