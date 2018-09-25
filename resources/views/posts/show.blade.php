@extends('layouts.app')

@section('content')
    <h1>{{$post->title}}</h1>

    <div>
        {!!$post->body!!}
    </div>
    <small class="card-body">Written on {{$post->created_at}}</small>
    <hr>
    <a href="/posts/{{$post->id}}/edit" class="btn btn-info" role="button">Edit</a>

    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method'=>'POST', 'style'=> 'float:right;']) !!}

        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
    {!! Form::close() !!}
    
    
@endsection