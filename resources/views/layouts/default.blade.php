<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="{{ url('assets/css/paper.bootstrap.min.css') }}">



</head>
<body id="@yield('bodyID')" class="@yield('class')">




@yield('content')




<script type='text/javascript' src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script type='text/javascript' src="{{ url('assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>


</body>
</html>