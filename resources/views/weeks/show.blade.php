@extends('layouts.default')
@section('title','FOCUS League – Week Details')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Cycle {{ $week->cycle->name }} - Wk{{ $week->index() }}</h4>
                    <h3 class="hidden-xs hidden-sm">Cycle {{ $week->cycle->name }} - Wk{{ $week->index() }} ({{ $week->starts_at->toFormattedDateString() }})</h3>
                    <p>Week overview</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul>
                    @foreach($week->games as $game)
                        <li><a href="{{ route('games.edit', $game->id) }}">{{ $game->division }} game</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-lg btn-danger">Mark As Rainout</button>
            </div>
        </div>
    </div>
@endsection