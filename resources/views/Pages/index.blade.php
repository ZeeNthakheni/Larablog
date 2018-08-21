@extends('layout.layout')

@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to my Laravel blog site!</h1>
        <p class="lead">This is my Laravel blog site stuff</p>
        <hr class="my-4">
        <p class="lead">
          <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
          <a class="btn btn-success btn-lg" href="/register" role="button">Register</a>
        </p>
      </div>
@endsection
