


<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GRID</title>

        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        {{-- https://code.jquery.com/jquery-3.3.1.js
        https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js --}}
        
        
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        {{-- <script src="cdn.datatables.net/plug-ins/1.10.19/pagination/ellipses.js"></script> --}}

    </head>
    <body>

    @include('inc.navbar')
    @include('inc.messages')

    <div class="container">
            <h3>Posts</h3>
    @if(count($posts)>0)
        <table data-order='[[ 0, "desc" ]]' id="table_id" class="display">
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
                    <td>{!!$post->body!!}</td>
                    {{-- <td>{{$post->city_name}}, {{$post->country_name}}</td> --}}
                    <td>{{$post->city->city_name}}, {{$post->country->country_name}}</td>

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
</div>

        <!-- Load Jqgrid scripts in your scripts section -->
        {{-- {!! Jqgrid::scripts() !!}

        <script>
        
            $('#jqgrid').jqGrid({
                url: '{{ url("foo/datagrid") }}',
                colModel: {!! Jqgrid::js_colmodel() !!}
            
            });
        </script> --}}
        <script>
            $(document).ready( function () {
                $('#table_id').DataTable({
                    dom: 'Blfrtip',
                    stateSave: true,
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                    // "processing": true,
                    // "serverSide": true,
                    // "ajax": "/ajax"
                });
            } );
        </script>
    </body>
</html>
