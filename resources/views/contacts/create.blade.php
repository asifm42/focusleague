@extends('layouts.default')
@section('title','FOCUS League – Contact Us')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                @include('contacts.forms.create')
            </div>
        </div>
    </div>
@endsection