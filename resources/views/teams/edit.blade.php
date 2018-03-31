@extends('layouts.default')
@section('title','FOCUS League – Edit Team')
@section('styles')

@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h4 class="text-center">Edit team for Cycle {{ $cycle->name }}</h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col col-sm-8 col-md-6">
                @include('teams.forms.create', ['edit'=>true])
            </div>
        </div>
    </div>
@stop