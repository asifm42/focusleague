@extends('layouts.default')
@section('title','FOCUS League – Admin Cycle Overview')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Week</h4>
            <h3 class="hidden-xs hidden-sm">Week</h3>
            <p>Week Overview</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                {{ $week->starts_at}}
                <h3>Players</h3>

                <ul>
                @foreach($week->players() as $player)
                    <li>{{ $player->name }}</li>
                @endforeach
                </ul>

                <h3>Subs</h3>
                <ul>
                @foreach($week->subsOnATeam as $sub)
                    <li>{{ $sub->name }}</li>
                @endforeach
                </ul>

                <h3>Transactions</h3>
                <ul>
                @foreach($week->transactions as $transaction)
                    <li>{{ $transaction->user->name }} - {{ $transaction->type }} - {{ $transaction->description }} - {{ $transaction->amount }}</li>
                @endforeach
                </ul>

                <h3>Games</h3>
                <ul>
                @foreach($week->games as $game)
                    <li> {{ $game->id }} </li>
                @endforeach
                </ul>


            </div>
        </div>
    </div>
@endsection