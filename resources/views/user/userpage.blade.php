@extends('layouts.app')
@section('title', 'Account')
@section('content')

    <h1 class="bg-white p-3 rounded-lg mb-2 text-black text-center">Hello {{auth()->user()->name}}</h1>

    <div class="bg-white p-3 rounded-lg m-3 text-black text-center " id="profile">
        <div class="row">
            <div class="col-md-6">
                <label>Username</label>
            </div>
            <div class="col-md-6">
                <p>{{ auth()->user()->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Email</label>
            </div>
            <div class="col-md-6">
                <p>{{ auth()->user()->email }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Password</label>
            </div>
            <div class="col-md-6">
                <p>*********</p>
            </div>
        </div>
        <div class="align-content-center text-center">
            <form action="{{route('profiles.show')}}" method="POST">
                @csrf
                @method('delete')
                <button onclick="return confirm('Are you sure?')" class="btn-danger text-black-50" type="submit">Delete Account</button>
            </form>
        </div>
    </div>

@endsection
