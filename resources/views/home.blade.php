@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="display:flex; justify-content: space-evenly;">
                        <div>
                            <img src='{{session('imageUrl')}}'/>
                        </div>
                        <div style="align-self:flex-end">
                            <h2>{{session('profileName')}}</h2>
                            <a href="/posts/create" class="btn btn-primary">Create Post</a>
                            <a href="/posts" class="btn btn-warning">View Post</a>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Popular Posts</div>

                <div class="card-body">
                    
                    @foreach ($posts as $post)
                        <h1>{{$post->title}}</h1>

                        <div>
                            {!!$post->body!!}
                        </div>
                        <small class="card-body">Written on {{$post->created_at}}</small>
                        <small class="card-body">No. of views: {{$post->views}}</small>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
