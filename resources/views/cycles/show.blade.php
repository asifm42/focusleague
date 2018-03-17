@extends('layouts.default')
@section('title','FOCUS League – Cycle Details')

@section('content')
    <div class="container">
        <h3>Cycle {{ $cycle->name }}</h3>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card mt-2 mb-2">
                    <div class="card-header">
                        <h6 class="card-title font-weight-bold mb-0">
                            Status
                        </h6>
                    </div>
                    <div class="card-body">
                        <dl class="m-0">
                            <dt>Format</dt>
                            <dd>{!! $cycle->format !!}</dd>
                            <dt>Your Status</dt>

                            @include('cycles.status-card-body', ['cycle' => $cycle, 'cycle_signup' => $current_cycle_signup, 'sub_weeks' => $sub_weeks])
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div id="schedule" class="card mt-2 mb-2">
                    <div class="card-header">
                        <h6 class="card-title font-weight-bold mb-0">
                            Schedule/Results
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                @for( $i=0, $len = $cycle->weeks()->count(); $i < $len; $i++)
                                    <tr class="table-secondary">
                                        <td colspan="5"><strong>Week {{ ($i+1) . ' - ' . $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong></td>
                                    </tr>
                                    @if($cycle->areTeamsPublished())
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
                                    @endif
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($cycle->areTeamsPublished())
            <div id="mensTeams" class="row">
                @foreach($cycle->teams->where('division', 'mens') as $team)
                    <div id="{{ snake_case($team->name) }}" class="col-12 col-sm-6">
                    @include('teams.card', $data = ['players'=>$team->players->load('user'), 'subs' => $team->subs->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                    </div>
                @endforeach
            </div>
            <div id="mixedTeams" class="row">
                @foreach($cycle->teams->where('division', 'mixed') as $team)
                    <div id="{{ snake_case($team->name) }}" class="col-12 col-sm-6">
                    @include('teams.card', $data = ['players'=>$team->players->load('user'), 'subs' => $team->subs->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                    </div>
                @endforeach
            </div>
            <div id="womensTeams" class="row">
                @foreach($cycle->teams->where('division', 'womens') as $team)
                    <div id="{{ snake_case($team->name) }}" class="col-12 col-sm-6">
                    @include('teams.card', $data = ['players'=>$team->players->load('user'), 'subs' => $team->subs->load('user'), 'cycle'=>$cycle, 'title' => 'Team '. $team->nameAndDivision(), 'team'=>$team])
                    </div>
                @endforeach
            </div>
        @else
            <div class = "row">
                <div id="maleSignups" class="col-12 col-sm-6">
                    @include('signups.card', $data = ['signups'=>$currentMaleSignups, 'cycle'=>$cycle, 'title' => 'Male signups', 'showDivisions'=>true])
                </div>
                <div id="femaleSignups" class="col-12 col-sm-6">
                    @include('signups.card', $data = ['signups'=>$currentFemaleSignups, 'cycle'=>$cycle, 'title' => 'Female signups', 'showDivisions'=>true])
                </div>
            </div>
        @endif

        <div class="row">
            <div id="maleSubs"  class="col-12 col-sm-6">
                @include('subs.panel_list', $data = ['cycle'=>$cycle, 'gender'=>'male'])
            </div>
            <div id="femaleSubs"  class="col-12 col-sm-6">
                @include('subs.panel_list', $data = ['cycle'=>$cycle, 'gender'=>'female'])
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $('document').ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush