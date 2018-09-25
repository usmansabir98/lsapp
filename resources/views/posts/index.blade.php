@extends('layouts.app')

@section('content')
    <h3>Posts</h3>
    @if(count($posts)>0)
        @foreach($posts as $post)
            <div class="card">
                <h3 class="card-header"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <small class="card-body">Written on {{$post->created_at}}</small>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection