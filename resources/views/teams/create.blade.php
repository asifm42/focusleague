@extends('layouts.default')
@section('title','FOCUS League – Create Team')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Create Team</h4>
            <h3 class="hidden-xs hidden-sm">Create Team</h3>
            <p>Create a team for a cycle.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('teams.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection