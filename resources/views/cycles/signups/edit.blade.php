@extends('layouts.default')
@section('title','FOCUS League – Edit Cycle Signup')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Edit Cycle {{ $cycle->name }} Sign-up</h4>
                    <h3 class="hidden-xs hidden-sm">Edit Cycle {{ $cycle->name }} Sign-up</h3>
                    <p>Edit your sign-up details</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('cycles.signups.forms.create', ['edit'=>true])
            </div>
        </div>
    </div>
@endsection