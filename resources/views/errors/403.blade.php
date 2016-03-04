@extends('layouts.default')
@section('title','FOCUS League – 403')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <h2>
                <i class="fa fa-exclamation-triangle"></i>
                <strong>404</strong>
                <small>Forbidden</small>
            </h2>
            <div class="well error">
                <p>{{ $exception->getMessage() }}</p>
            </div>
        </div>
    </div>
</div>

@endsection