@extends('layouts.default')
@section('title','FOCUS League – Player Ultimate History')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Ultimate History</h4>
            <h3 class="hidden-xs hidden-sm">Ultimate History</h3>
            <p>Share your ultimate history</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('ultimate_history.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection