@extends('layouts.default')
@section('title','FOCUS League – Edit Player Profile')
@section('styles')

@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h3 class="text-center">Edit Profile</h3>
                <p class="text-center">Make changes to your profile.</p>
                @include('users.forms.create', ['edit' => true])
            </div>
        </div>
    </div>
@stop