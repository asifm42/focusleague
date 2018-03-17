@extends('layouts.default')
@section('title','FOCUS League – Welcome')

@section('content')
    <div class="container">
<!-- ########## START XS/SM ########## -->
        <div class="text-center d-lg-none">
            @include('site.welcome-mobile')
        </div>
<!-- ########## END XS/SM ########## -->
<!-- ########## START MD/LG ########## -->
        <div class="text-center d-none d-lg-block">
            @include('site.welcome-desktop')
        </div>
<!-- ########## END MD/LG ########## -->
    </div>
@endsection