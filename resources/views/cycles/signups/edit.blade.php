@extends('layouts.default')
@section('title','FOCUS League – Edit Cycle Signup')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h3 class="text-center">Edit Cycle {{ $cycle->name }} Sign-up</h3>
                <p class="text-center">Edit your sign-up details</p>
                @include('cycles.signups.forms.create', ['edit'=>true])
            </div>
        </div>
    </div>
@endsection