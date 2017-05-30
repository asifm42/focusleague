@extends('layouts.default')
@section('title','FOCUS League – Edit Game')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Edit Game {{ $game->id }}</h4>
                    <h3 class="hidden-xs hidden-sm">Edit Game {{ $game->id }}</h3>
                    <p>Edit game details</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                @include('games.form')
            </div>
        </div>
    </div>
@endsection