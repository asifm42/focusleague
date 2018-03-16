@extends('layouts.default')
@section('title','FOCUS League – Edit Cycle Signup')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6">
                <h3 class="text-center">Cycle {{ $cycle->name }}</h3>
                <p class="text-center my-2">Sign-up details</p>
                <p class="text-center my-2"><span class="badge badge-warning">Editing</span></p>
                @include('cycles.signups.forms.create', ['edit'=>true])
            </div>
        </div>
    </div>
@endsection