<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#1e3e47">
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