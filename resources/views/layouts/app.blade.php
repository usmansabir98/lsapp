<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</head>
<body>
        

    @include('inc.navbar')
    <div class="container">
        @include('inc.messages')
        @yield('content')
    </div>

        

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        // CKFinder.setupCKEditor();
        // CKEDITOR.replace( 'article-ckeditor', {
        //     filebrowserBrowseUrl: '/browser/browse.php',
        //     filebrowserUploadUrl: '/uploader/upload.php'
        // });
        // CKEDITOR.replace( 'editor1', {
        //     filebrowserBrowseUrl: '/browser/browse.php',
        //     filebrowserUploadUrl: '/uploader/upload.php'
        // });

        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };

        CKEDITOR.replace( 'article-ckeditor', options);
    </script>

    <script>
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>

    <script src="{{ asset('js/create.js') }}"></script>

    <script>
    
        // window.onbeforeunload = function (e) {
        //     e = e || window.event;

        //     // For IE and Firefox prior to version 4
        //     if (e) {
        //         e.returnValue = 'Are you sure?';
        //     }

        //     // For Safari
        //     return 'Are you sure?';
        // };

        // window.onbeforeunload = function (evt) {
        //     if (sncro != 1) {
        //         var message = 'Are you sure you want to leave, cause there are some unsaved changes?';
        //         if (typeof evt == 'undefined') {
        //             evt = window.event;
        //         }
        //         if (evt ) {
        //             evt.returnValue = message;
        //         }
        //         return message;
        //     }
        // }
                

    </script>

</body>
</html>
