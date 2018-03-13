@extends('layouts.default')
@section('title','FOCUS League – Cycle Sign-up')

@section('content')
    <div class="container">
         <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                    <h3 class="text-center">Cycle {{ $cycle->name }} Sign-up</h3>
                    <p class="text-center">Sign up for the cycle</p>
                @include('cycles.signups.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection