@extends('layout.layout')

@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
    
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>

    <hr>
    <a href="/posts/{{$post->id}}/edit" class="btn btn-primary float-left" role="button">Edit Post</a>
    
    
    {!! Form::open(['PostsController@destroy',$post->id],['method' => 'POST', 'class' => 'float-right']) !!}
        {!! Form::hidden('_method', 'DELETE') !!}
        {!! Form::submit('Delete Post', ['class' => 'btn btn-danger float-right']) !!}
    {!! Form::close() !!}
   
@endsection