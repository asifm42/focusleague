@extends('layouts.default')
@section('title','FOCUS League – Cycle Details')

@section('styles')

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.css">
    <style>
        .menu-btn {
            position:fixed;
            right:15px;
            bottom:15px;
            z-index: 1000;
        }

        .affix-top,.affix{
            position: static;
        }

        @media (min-width: 979px) {
          #sidebar.affix-top {
            position: static;
            width:228px;
          }

          #sidebar.affix {
            position: fixed;
            top:30px;
            width:228px;
          }
        }

        #sidebar li.active {
            border:0 #eee solid;
            border-right-width:4px;
        }

    </style>
@stop

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
    <button class="btn btn-primary menu-btn visible-xs visible-sm hidden-md hidden-lg" data-toggle="offcanvas" data-target="#sideNav">NAV</button>
    <div class="container">
        <nav id="sideNav" class="navmenu navmenu-default navmenu-fixed-left offcanvas-xs offcanvas-sm hidden-md hidden-lg" role="navigation">
            <span class="navmenu-brand">Cycle {{ $cycle->name }}</span>
            <ul class="nav navmenu-nav">
                @include('cycles.showMenuItems')
            </ul>
        </nav>
        <div class="row">
            <div class="hidden-xs hidden-sm col-md-3">
                <ul id="sidebar" class="nav nav-pills nav-stacked well well-sm">
                    @include('cycles.showMenuItems')
                </ul>
            </div>

            <div class="col-xs-12 col-md-9">
                <div class="row">
                    <div class="col-xs-12 col-md-4">

                    <div id="details" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Details</h4>
                        </div>
                        <div class="panel-body">
                            <dl class="hidden">
                                <dt>Name</dt>
                                <dd>{{ $cycle->name }}</dd>
                            </dl>
                            <dl>
                                <dt>Format</dt>
                                <dd>{{ $cycle->format }}</dd>
                            </dl>
                            <dl>
                                <dt>Current Status</dt>
                                @if ($current_cycle_signup)
                                    @if($cycle->areTeamsPublished())
                                        @if (is_null($current_cycle_signup->pivot->team_id))
                                            <dd>You are signed up but not placed on a team yet.</dd>
                                        @else
                                            <dd>You are on team: <em>{{ucwords($cycle->teams->find($current_cycle_signup->pivot->team_id)->name)}}</em></dd>
                                        @endif
                                        @if ($current_cycle_signup->pivot->will_captain == true)
                                            @if ($current_cycle_signup->pivot->captain == true)
                                                <dd>You are captaining.</dd>
                                            @else
                                            @endif
                                        @else
                                        @endif
                                    @else
                                        <dd>You are signed up but not placed on a team yet.</dd>
                                        @if ($current_cycle_signup->pivot->will_captain == true)
                                            <dd>You are willing to captain.</dd>
                                        @else
                                            <dd>You are NOT willing to captain.</dd>
                                        @endif
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
                                        <dd><a href="{{ route('sub.edit', $sub_week['deets']->pivot->id) }}">{{ $sub_week['week']->starts_at->toFormattedDateString() }}</a></dd>
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

                    </div>
                    <div class="col-xs-12 col-md-8">

                    <div id="schedule" class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Schedule/Results</h4>
                        </div>
                        <div class="panel-body">
                            @if($cycle->areTeamsPublished())
                        <div class="table-responsive">
    <table class="table table-condensed table-striped">
                                <tr class="hidden">
                                  <th>Div</th>
                                  <th class="text-center" colspan="3">Teams</th>
                                  <th class="text-right">Time</th>
                                </tr>
                            @for( $i=0, $len = $cycle->weeks()->count(); $i < $len; $i++)
                                <tr class="warning">
                                    <td colspan="5"><strong>Week {{ ($i+1) . ' - ' . $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong></td>
                                </tr>
                                @if($cycle->weeks[$i]->isRainedOut())
                                    <tr>
                                        <th colspan=5 class="text-center">RAINED OUT</th>
                                    </tr>
                                @endif
                                @foreach($cycle->weeks[$i]->games as $game)
                                    @if($cycle->weeks[$i]->isRainedOut())
                                        <tr class="rainedOut" style="text-decoration: line-through;">
                                    @else
                                        <tr>
                                    @endif
                                        @if(strtolower($game->teams[0]->division) === 'mens')
                                            <td class="text-center"><i class="fa fa-fw fa-male text-primary"></i></td>
                                        @elseif (strtolower($game->teams[0]->division) === 'womens')
                                            <td class="text-center"><i class="fa fa-fw fa-female text-info"></i></td>
                                        @else
                                            <td class="text-center"><i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i></td>
                                        @endif
                                        <td class="text-right">{{ ucwords($game->teams[0]->name) }}&nbsp;{{ $game->teams[0]->pivot->points_scored }}</td>
                                        <td class="text-center">vs</td>
                                        <td class="text-left">{{ $game->teams[1]->pivot->points_scored }}&nbsp;{{ ucwords($game->teams[1]->name) }}</td>
                                        <td class="text-center">{{ $game->starts_at->format('g:ia') }}-{{ $game->ends_at->format('g:ia') }}</td>
                                    </tr>
                                @endforeach

                            @endfor
                            </table>
                            </div>
                            @else


                            <ul class='list-unstyled'>
                            @for( $i=0, $len = $cycle->weeks()->count(); $i < $len; $i++)
                                <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) . ' - ' . $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong></li>

                                <ul class='list-unstyled hidden'>
                                    @foreach($cycle->weeks[$i]->games as $game)
                                        <li>{{ ucwords($game->teams[0]->name) }} v {{ ucwords($game->teams[1]->name) }} | 8p-10p</li>
                                    @endforeach
                                </ul>
                            @endfor
                            </ul>
                            @endif
                        </div>
                    </div>

                    </div>

                </div>

                <div class="row" id="teams">
                <div class="col-xs-12">
                    @if($cycle->areTeamsPublished())
                        <div id="mensTeams" class="row">
                        @foreach($cycle->teams->where('division', 'mens') as $team)
                            <div id="{{ snake_case($team->name) }}" class="col-xs-12 col-sm-6">
                            @include('teams.panel', $data = ['players'=>$team->players->load('user'), 'subs' => $team->subs->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                            </div>
                        @endforeach
                        </div>
                        <div id="mixedTeams" class="row">
                        @foreach($cycle->teams->where('division', 'mixed') as $team)
                            <div id="{{ snake_case($team->name) }}" class="col-xs-12 col-sm-6">
                            @include('teams.panel', $data = ['players'=>$team->players->load('user'), 'subs' => $team->subs->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                            </div>
                        @endforeach
                        </div>
                        <div id="womensTeams" class="row">
                        @foreach($cycle->teams->where('division', 'womens') as $team)
                            <div id="{{ snake_case($team->name) }}" class="col-xs-12 col-sm-6">
                            @include('teams.panel', $data = ['players'=>$team->players->load('user'), 'subs' => $team->subs->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                            </div>
                        @endforeach
                        </div>
                    @else
                    <div class = "row">
                    <div id="maleSignups" class="col-xs-12 col-sm-6">
                        @include('signups.panel', $data = ['signups'=>$currentMaleSignups, 'cycle'=>$cycle, 'title' => 'Male signups', 'showDivisions'=>true])
                    </div>
                    <div id="femaleSignups" class="col-xs-12 col-sm-6">
                        @include('signups.panel', $data = ['signups'=>$currentFemaleSignups, 'cycle'=>$cycle, 'title' => 'Female signups', 'showDivisions'=>true])
                    </div>
                    </div>
                    @endif
                </div>
                </div>
                <div class="row">
                <div id="maleSubs"  class="col-xs-12 col-sm-6">
                    @include('subs.panel_list', $data = ['cycle'=>$cycle, 'gender'=>'male'])
                </div>
                <div id="femaleSubs"  class="col-xs-12 col-sm-6">
                    @include('subs.panel_list', $data = ['cycle'=>$cycle, 'gender'=>'female'])
                </div>
                </div>
            </div>

        </div>
    </div>
@stop

@push('scripts')
    <script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.js'></script>
    <script>
        $('document').ready(function() {
            $('#sideNav li a').click(function() {
                $('#sideNav').offcanvas('toggle');
                $('#sideNav li').removeClass('active')
                $(this).parent().addClass('active');
            })
            $('#sidebar li a').click(function() {
                $('#sidebar li').removeClass('active')
                $(this).parent().addClass('active');
            })

            $('#sidebar').affix({
                  offset: {
                    top: 245
                  }
            });

            var $body   = $(document.body);
            var navHeight = $('.navbar').outerHeight(true) + 10;

            $body.scrollspy({
                target: '#leftCol',
                offset: navHeight
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush