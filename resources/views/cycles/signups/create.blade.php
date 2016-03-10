@extends('layouts.default')
@section('title','FOCUS League – Cycle Sign-up')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Cycle {{ $cycle->name }} Sign-up</h4>
                    <h3 class="hidden-xs hidden-sm">Cycle {{ $cycle->name }} Sign-up</h3>
                    <p>Sign up for the cycle</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('cycles.signups.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection