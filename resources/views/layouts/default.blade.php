<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

@if (App::environment('production'))
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/site.min.css') }}">
@elseif (App::environment('local'))
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/site.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/default.css') }}">
@else
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/site.css') }}">
@endif

@yield('styles')

</head>
<body id="@yield('bodyID')" class="@yield('class')">

@include('navbars.default')

@include('flash::message')

@yield('content')

@include('layouts.footer')

@if (App::environment('production'))
    <script type='text/javascript' src="{{ url('assets/js/site.min.js') }}"></script>
@else
    <script type='text/javascript' src="{{ url('assets/js/site.js') }}"></script>
@endif

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