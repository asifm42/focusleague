@extends('layouts.default')
@section('title','FOCUS League – Contact Us')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8">
                @include('contacts.forms.create')
            </div>
        </div>
    </div>
@endsection