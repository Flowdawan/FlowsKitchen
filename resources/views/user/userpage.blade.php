@extends('layouts.app')
@section('title', 'Account')

@section('header_scripts',)
    <script type="text/javascript" src="{{ asset('js/changeAccount.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">

@endsection
@section('content')
    <h1 class="bg-white p-3 rounded-lg mb-2 text-black text-center">Hello {{auth()->user()->name}}</h1>

    <div class="bg-white p-3 rounded-lg m-3 text-black text-center" id="profile">
        <form action="{{route('profiles.show')}}" method="POST">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6">
                    <p>Username</p>
                </div>
                <div class="col-md-6">
                    <input id="name" type="text" disabled class=" text-center @error('name') is-invalid @enderror"
                           name="name" value="{{ auth()->user()->name  }}" autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>E-Mail</p>
                </div>
                <div class="col-md-6">
                    <input id="email" type="email" disabled
                           class="text-center @error('email') is-invalid @enderror" name="email"
                           value="{{ auth()->user()->email }}" autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row" id="password_div">
                <div class="col-md-6">
                    <p>Password</p>
                </div>
                <div class="col-md-6">
                    <input id="password" type="password" disabled
                           class="text-center @error('password') is-invalid @enderror" name="password"
                           value="*******" autocomplete="password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>
            <div class="row" id="password_div">
                <div class="col-md-6">
                    <p id="password_change" hidden>Password confirmation</p>
                </div>
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" disabled hidden
                           class="text-center" name="password_confirmation"
                           value="">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>You have still saved recipes</p>
                </div>
                <div class="col-md-6">
                    <p id="recipe_count"></p>
                </div>
            </div>
            <div class="align-content-center text-center">

                <button onclick="changeAccount()" class="btn-info text-black-50 m-2" id="edit_button" type="button">
                    Change
                    Account
                </button>
                <button class="btn-success text-black-50 m-2" id="save_button" hidden type="submit">
                    Save
                </button>
            </div>
        </form>

        <form action="{{route('profiles.show')}}" method="POST">
            @csrf
            @method('delete')
            <button onclick="return confirm('Are you sure?')" class="btn-danger text-black-50" type="submit"
                    id="delete_button">Delete
                Account
            </button>
        </form>
    </div>


@endsection
