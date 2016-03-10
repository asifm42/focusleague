@extends('layouts.default')
@section('title','FOCUS League – Player Signup')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Sign up</h4>
            <h3 class="hidden-xs hidden-sm">Sign up</h3>
            <p>Create a new player account</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('users.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection