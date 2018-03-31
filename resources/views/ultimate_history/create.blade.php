@extends('layouts.default')
@section('title','FOCUS League – Player Ultimate History')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-sm-6">
                <h4 class="text-center">Ultimate History</h4>
                <p class="text-center">Share your ultimate history</p>
                @include('ultimate_history.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection