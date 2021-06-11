@extends('layouts.app')
@section('title', 'Account')
@section('content')

    <h1 class="bg-white p-3 rounded-lg mb-4 text-black text-center">Hello {{auth()->user()->name}}</h1>


@endsection
