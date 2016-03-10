@extends('layouts.default')
@section('title','FOCUS League – Contact Us')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Contact Us</h4>
            <h3 class="hidden-xs hidden-sm">Contact Us</h3>
            <p>Got a question or feedback? Get in touch!</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('contacts.forms.create')
            </div>
        </div>
    </div>
@endsection