<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    {{-- @see https://mathiasbynens.be/notes/touch-icons --}}
{{--
    <link rel="icon" sizes="192x192" href="{{ url('assets/core/images/appicon/touch-icon-192x192.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="{{ url('assets/core/images/appicon/apple-touch-icon-60@3x.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ url('assets/core/images/appicon/apple-touch-icon-76@2x.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('assets/core/images/appicon/apple-touch-icon-72@2x.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ url('assets/core/images/appicon/apple-touch-icon-60@2x.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ url('assets/core/images/appicon/apple-touch-icon-57@2x.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ url('assets/core/images/appicon/apple-touch-icon-76.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ url('assets/core/images/appicon/apple-touch-icon-76.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ url('assets/core/images/appicon/apple-touch-icon-57.png') }}">
--}}
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