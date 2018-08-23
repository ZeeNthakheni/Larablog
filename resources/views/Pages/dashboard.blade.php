@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                
                <div class="card-body">
                        <a href="/posts/create" class="btn btn-primary">Create Post</a>
                        <hr>
                    <h3>Your Blog Posts</h3>
                    @if (count($posts)>0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($posts as $post)
                            <tr>
                                <td><a href="/posts/{{$post->id}}">{{$post->title}}</a></td>
                                <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit Post</a></td>
                                <td>
                                    <form method="POST" action="/posts/{{$post->id}}" class="float-right">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    
                                        <div class="form-group">
                                                <input type="submit" class="btn btn-danger delete-user" value="Delete Post">
                                        </div>
                                    </form>                                
                                </td>
                            </tr> 
                            @endforeach
                        </table>
                    @else
                      <p>You have no posts</p>  
                      
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
