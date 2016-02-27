@extends('layouts.default')
@section('title','FOCUS League – Sign in')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('auth.forms.signIn')
            </div>
        </div>
    </div>
@stop
