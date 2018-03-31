@extends('layouts.default')
@section('title','FOCUS League – Substitute Registration')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                @include('subs.forms.create', ['edit'=>false])
            </div>
        </div>
    </div>
@endsection