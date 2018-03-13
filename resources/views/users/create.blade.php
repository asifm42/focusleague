@extends('layouts.default')
@section('title','FOCUS League – Player Signup')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h3 class="text-center">Player account sign up</h3>
                @include('users.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection