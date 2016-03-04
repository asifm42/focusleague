@extends('layouts.default')
@section('title','FOCUS League – Player Registration')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h2>Sign up</h2>
            <p>Create a new account</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('users.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@stop