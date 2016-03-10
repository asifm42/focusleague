@extends('layouts.default')
@section('title','FOCUS League – Edit Player Profile')
@section('styles')

@stop
@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Edit Profile</h4>
            <h3 class="hidden-xs hidden-sm">Edit Profile</h3>
            <p>Make changes to your profile.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('users.forms.create', ['edit' => true])
            </div>
        </div>
    </div>
@stop