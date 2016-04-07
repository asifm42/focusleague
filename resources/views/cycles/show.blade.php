@extends('layouts.default')
@section('title','FOCUS League – Cycle Details')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h4 class="hidden-md hidden-lg">Cycle {{ $cycle->name }}</h4>
                    <h3 class="hidden-xs hidden-sm">Cycle {{ $cycle->name }}</h3>
                    <p>Cycle overview</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Details</h4>
                    </div>
                    <div class="panel-body">
                        <dl class="horizontal">
                            <dt>Name:</dt>
                            <dd>{{ $cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{{ $cycle->format }}</dd>
                            <dt>Current Status</dt>
                            @if ($current_cycle_signup)
                                @if($cycle->areTeamsPublished())
                                    @if (is_null($current_cycle_signup->pivot->team_id))
                                        <dd>You are signed up but not placed on a team yet.</dd>
                                    @else
                                        <dd>You are on team: <em>{{ucwords($cycle->teams->find($current_cycle_signup->pivot->team_id)->name)}}</em></dd>
                                    @endif
                                @else
                                    <dd>You are signed up but not placed on a team yet.</dd>
                                @endif
                                @if ($current_cycle_signup->pivot->will_captain == true)
                                    <dd>You are willing to captain.</dd>
                                @else
                                    <dd>You are NOT willing to captain.</dd>
                                @endif
                                @if ($cycle->status() === 'SIGNUP_OPEN')
                                    <dd>Sign up is currently open until {{ $cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.edit', $cycle->id) }}">Edit sign up</a>
                                @elseif ($cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess</dd>
                                @elseif ($cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed.</dd>
                                @endif
                            @elseif($sub_weeks)
                                <dd>You are signed up as a sub for the following weeks</dd>
                                @foreach($sub_weeks as $sub_week)
                                    <dd><a href="{{ route('sub.edit', $sub_week['deets']->id) }}">{{ $sub_week['week']->starts_at->toFormattedDateString() }}</a></dd>
                                @endforeach
                                <a class="btn btn-default btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
                            @else
                                @if ($cycle->status() === 'SIGNUP_OPENS_LATER')
                                    <dd>Sign up opens at {{ $cycle->signup_opens_at->toDayDateTimeString() }}</dd>
                                @elseif ($cycle->status() === 'SIGNUP_OPEN')
                                    <dd>Sign up is currently open until {{ $cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.create', $cycle->id) }}">Sign up</a>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
                                @elseif ($cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
                                @elseif ($cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess. Sign-ups are closed but you can sign up as a sub.</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
                                @elseif ($cycle->status() === 'COMPLETED')
                                    <dd>Completed</dd>
                                @endif
                            @endif
                        </dl>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Schedule</h4>
                    </div>
                    <div class="panel-body">
                        <ul class='list-unstyled'>
                        @for( $i=0, $len = $cycle->weeks()->count(); $i < $len; $i++)
{{--
                            <li>{{'Week ' . ($i+1) . ' - ' . $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</li>
--}}
                            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) . ' - ' . $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong></li>

                            <ul class='list-unstyled'>
                                @foreach($cycle->weeks[$i]->games as $game)
                                    <li>{{ ucwords($game->teams[0]->name) }} v {{ ucwords($game->teams[1]->name) }} | 8p-10p</li>
                                @endforeach
                            </ul>

                        @endfor
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-5">
                @if($cycle->areTeamsPublished())
                    @foreach($cycle->teams as $team)
                        @include('teams.panel', $data = ['players'=>$team->players->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                    @endforeach
                @else
                    @include('signups.panel', $data = ['signups'=>$currentMaleSignups, 'cycle'=>$cycle, 'title' => 'Male signups', 'showDivisions'=>true])
                    @include('signups.panel', $data = ['signups'=>$currentFemaleSignups, 'cycle'=>$cycle, 'title' => 'Female signups', 'showDivisions'=>true])
                @endif
            </div>
            <div class="col-xs-12 col-md-3">
                @include('subs.panel_list', $data = ['cycle'=>$cycle, 'gender'=>'male'])
                @include('subs.panel_list', $data = ['cycle'=>$cycle, 'gender'=>'female'])
            </div>

        </div>
    </div>
@stop