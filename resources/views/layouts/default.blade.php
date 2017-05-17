<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    <meta name="description" content="The FOCUS League is a competitve ultimate frisbee league in Houston, TX." />

    <title>@yield('title')</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#1e3e47">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/css/app.css">
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

<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/app.js"></script>

<script>
    $(document).ready(function(){

      $('[data-toggle="popover"]').popover();

      $('[data-toggle="tooltip"]').tooltip();

      $('[data-toggle="dropdown"]').dropdown();

      // $('.timeago').each(function(){
      //   $(this).text( moment( $(this).attr('datetime') ).fromNow() );
      // });

    });
</script>

@stack('scripts')

{{-- @include('google.analytics') --}}

</body>

@yield('modals')

</html>