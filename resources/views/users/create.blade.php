@extends('layouts.default')
@section('title','FOCUS League – Player Registration')
@section('styles')

@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md -6">
                @include('users.forms.create')
            </div>
        </div>
    </div>
@stop