@extends('layouts.default')
@section('title','FOCUS League – Edit Sub Sign Up')
@section('styles')

@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-6">
                <h4 class="text-center w-100">Sub placement</h4>
                @include('subs.forms.teamPlacement')
            </div>
        </div>
    </div>
@stop