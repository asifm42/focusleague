@extends('layouts.default')
@section('title','FOCUS League – Edit Sub Sign Up')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Edit Sub Sign Up</h4>
            <h3 class="hidden-xs hidden-sm">Edit Sub Sign Up</h3>
            <p>Make changes to your sub sign up.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('subs.forms.create', ['edit' => true])
            </div>
        </div>
    </div>
@stop