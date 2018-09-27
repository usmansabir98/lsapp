@extends('layouts.app')

@section('content')
    <h3>Posts</h3>
    @if(count($posts)>0)
        <table id="table_id" class="display">
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Post Title</th>
                    <th>Post Body</th>
                    <th>City, Country</th>

                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                {{-- <div class="card">
                    <h3 class="card-header"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                    <small class="card-body">Written on {{$post->created_at}}</small>
                </div> --}}

                <tr>
                    <td>{{$post->id}}</td>
                    <td><a href="/posts/{{$post->id}}">{{$post->title}}</a></td>
                    <td>{{$post->body}}</td>
                    <td>{{$post->city_name}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>

                </tr>     
            @endforeach
            </tbody>
        </table>
        {{-- {{$posts->links()}} --}}
    @else
        <p>No posts found</p>
    @endif
@endsection