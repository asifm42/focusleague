@extends('layouts.default')
@section('title','FOCUS League – Substitute Registration')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Sub Sign up</h4>
            <h3 class="hidden-xs hidden-sm">Sub Sign up</h3>
            <p>Sign up as a sub</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('subs.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection