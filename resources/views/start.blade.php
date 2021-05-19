@extends('layouts.app')

@section('content')

<link href="{{ asset('css/start.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<br>
<h1 class="alert-dark pt-5" id ="hello"> Hello {{$name}} and welcome to our new Website here is a number: {{$id}} </h1>
