@extends('layouts.app')

@section('header')
    <h2 class="h4 font-weight-bold">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ __("You're logged in!") }}</h5>
        </div>
    </div>
@endsection