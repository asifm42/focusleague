@extends('layouts.default')
@section('title','FOCUS League – Forgot your password?')

@section('content')
    <div class="page-header">
        <div class="container">
            <h2>Forgot your password? Can't sign in?</h2>
            <p>Don't worry, it happens to all of us. Enter your email address below and we'll send you password reset instructions.</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('auth.forms.forgotPassword')
            </div>
        </div>
    </div>
@endsection