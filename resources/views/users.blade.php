@extends('layouts.app')

@section('content')
    Users!
    or just go to <a href = "<?php echo route('hello.show', [1]) ?>">users</a>
    or back <a href = "<?=url('/') ?>">to start</a>
@stop
