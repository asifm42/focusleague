@extends('layouts.default')
@section('title','FOCUS League – Change your password')
@section('content')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-sm-6">
                @include('auth.forms.resetPassword')
            </div>
        </div>
    </div>
@endsection