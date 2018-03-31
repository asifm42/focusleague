@extends('layouts.default')
@section('title','FOCUS League – Create Team')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h4 class="text-center">Create team for Cycle {{ $cycle->name }}</h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col col-sm-8 col-md-6">
                @include('teams.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection