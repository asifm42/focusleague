@extends('layouts.default')
@section('title','FOCUS League – Sign in')

@section('content')
    <div class="page-header">
        <div class="container">
            <h2>Sign in</h2>
            <p>Sign in to access your account.</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('auth.forms.signIn')
            </div>
        </div>
    </div>
@stop
