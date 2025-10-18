@extends('layouts.admin')

@section('content')
    <h1>Create Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" placeholder="Title">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" class="form-control" placeholder="Body"></textarea>
        </div>
        <div class="form-group">
            <input type="file" name="cover_image">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection