@extends('layouts.default')
@section('title','FOCUS League – Edit Sub Sign Up')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Sub placement</h4>
            <h3 class="hidden-xs hidden-sm">Sub placement</h3>
            <p>Place a sub on a team.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('subs.forms.teamPlacement')
            </div>
        </div>
    </div>
@stop