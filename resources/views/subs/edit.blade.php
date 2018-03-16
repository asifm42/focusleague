@extends('layouts.default')
@section('title','FOCUS League – Edit Sub Sign Up')
@section('styles')

@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                @include('subs.forms.create', ['edit' => true])
            </div>
        </div>
    </div>
@stop