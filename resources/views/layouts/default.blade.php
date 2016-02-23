<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


{{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/paper.bootstrap.min.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/font-awesome.min.css') }}"> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ url('assets/css/site.min.css') }}"> --}}
    @yield('styles')

</head>
<body id="@yield('bodyID')" class="@yield('class')">

@include('navbars.default')

@include('flash::message')

@yield('content')

@include('layouts.footer')

{{-- <script type='text/javascript' src="{{ url('assets/js/jquery.min.js') }}"></script> --}}
<script type='text/javascript' src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script type='text/javascript' src="{{ url('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script>
    $(document).ready( function () {
        // For popovers on the navbar
        // $('[data-toggle="popover"]').popover();
    })
</script>

@yield('scripts')

{{-- @include('google.analytics') --}}

</body>
</html>