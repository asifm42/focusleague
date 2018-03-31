@extends('layouts.default')
@section('title','FOCUS League – Forgot your password?')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                @include('auth.forms.forgotPassword')
            </div>
        </div>
    </div>
@endsection