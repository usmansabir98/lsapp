
<a href="/posts/{{$id}}" class="btn btn-info" role="button" style="float:right;">View</a>
{{-- @if(!Auth::guest()) --}}
{!! Form::open(['action' => ['PostsController@destroy', $id], 'method'=>'POST', 'style'=> 'float:right;']) !!}

        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class'=>'btn btn-danger'])}}
{!! Form::close() !!}

{{-- @endif --}}
