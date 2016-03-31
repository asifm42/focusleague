<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/manifest.json">
<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#2196f3">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">



@if (App::environment('production'))
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/site.min.css') }}">
@elseif (App::environment('local'))
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/site.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/default.css') }}">
   {{--<link rel="stylesheet" type="text/css" href="{{ url('assets/css/bootstrap-datetimepicker.css') }}" --}}
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