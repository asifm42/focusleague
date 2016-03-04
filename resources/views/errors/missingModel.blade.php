@inject('request', 'Illuminate\Http\Request')
@extends('layouts.default')
@section('title', 'FOCUS League – 404')
@section('content')

@if ($request->is('users/*'))
    <?php $type = 'user' ?>
@elseif ($request->is('cycles/*'))
    <?php $type = 'cycle' ?>
@else
    <?php $type = 'item' ?>
@endif

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <h2>
                <i class="fa fa-exclamation-triangle"></i>
                <strong>404</strong>
                <small>{{ ucwords($type) }} not found</small>
            </h2>
            <div class="well error">
                <p>The {{ $type }} you requested could not be found.</p>
            </div>
        </div>
    </div>
</div>

@stop