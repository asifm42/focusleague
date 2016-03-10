@extends('layouts.default')
@section('title','FOCUS League – Change your password')
@section('content')

    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Change your password</h4>
            <h3 class="hidden-xs hidden-sm">Change your password</h3>
            <p>Complete the form below to change your password</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('auth.forms.resetPassword')
            </div>
        </div>
    </div>
@endsection