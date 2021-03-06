@extends('layouts.default')
@section('title','FOCUS League – Player Dashboard')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Dashboard</h4>
            <h3 class="hidden-xs hidden-sm">Dashboard</h3>
            <p>Overview of your account.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Balance</div>
                    <div class="panel-body">
                        @if ($balance > 0)
                            <h6>You currently owe ${{ $balance }}.</h6>
                            <h6>You can pay via the following methods:</h6>
                            @component('site.payment_methods', ['balance' => $user->getBalance()])
                            @endcomponent
                        @elseif ($balance == 0)
                            <h6>Your balance is $0.00.</h6>
                            <h6>Thank you for being current!</h6>
                        @elseif ($balance < 0)
                            <h6>You currently have a credit of ${{ number_format(abs($balance), 2, '.',',') }}.</h6>
                            <h6>It will be applied towards your next charge.</h6>
                        @endif
                        @if(auth()->user() == $user)
                            <a href="{{ route('balance.details') }}" class="btn btn-default btn-block">See balance details</a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('users.balance', $user->id) }}" class="btn btn-default btn-block">See balance details</a>
                        @else
                        @endif
                    </div>
                </div>
            @if(!empty($current_cycle))
                <div class="panel panel-default">
                    <div class="panel-heading">Current Cycle</div>
                    <div class="panel-body">

                        <dl class="horizontal">
                            <dt>Name</dt>
                            <dd>{{ $current_cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{{ $current_cycle->format }}</dd>

                            @if (!$current_cycle_signup )
                                <dt>Schedule</dt>
                                @foreach( $current_cycle->weeks as $week )
                                    <dd>{{ $week->starts_at->toFormattedDateString() }}</dd>
                                @endforeach
                            @endif
                            <dt>Current Status</dt>
                            @if ($current_cycle_signup)
                                @if (is_null($current_cycle_signup->pivot->team_id))
                                    <dd>You are signed up but not placed on a team yet.</dd>
                                @else
                                    <dd>You are on team: <em>{{ucwords($current_cycle->teams->find($current_cycle_signup->pivot->team_id)->name)}}</em></dd>
                                @endif
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        <th class="text-center">Div1</th>
                                        <th class="text-center">Div2</th>
                                        @foreach($current_cycle->weeks as $key=>$week)
                                            <th class="text-center">Wk{{ $key+1 }}</th>
                                        @endforeach
                                        <th class="text-center">Will capt?</th>
                                    </tr>
                                    <tr>

                                    <td class="text-center">
                                        @if(strtolower($current_cycle_signup->pivot->div_pref_first) === 'mens')
                                            <i class="fa fa-male fa-fw text-primary"></i>
                                        @elseif(strtolower($current_cycle_signup->pivot->div_pref_first) === 'mixed')
                                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                                        @elseif(strtolower($current_cycle_signup->pivot->div_pref_first) === 'womens')
                                            <i class="fa fa-female fa-fw text-info"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(strtolower($current_cycle_signup->pivot->div_pref_second) === 'mens')
                                            <i class="fa fa-male fa-fw text-primary"></i>
                                        @elseif(strtolower($current_cycle_signup->pivot->div_pref_second) === 'mixed')
                                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                                        @elseif(strtolower($current_cycle_signup->pivot->div_pref_second) === 'womens')
                                            <i class="fa fa-female fa-fw text-info"></i>
                                        @endif
                                    </td>

                                        @foreach($user->availability()->where('cycle_id', $current_cycle->id)->get() as $week)
                                            @if($week->pivot->attending)
                                                <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                                            @else
                                                <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            @if ($current_cycle_signup->pivot->will_captain)
                                            <i class="fa fa-check fa-fw text-success"></i>
                                            @else
                                            <i class="fa fa-times fa-fw text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @if (!empty($current_cycle_signup->pivot->note))
                                        <tr>
                                            <td colspan="6">
                                                <i class="fa fa-sticky-note text-warning"></i>&nbsp;&nbsp;{{ $current_cycle_signup->pivot->note }}
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                                @if ($current_cycle->status() === 'SIGNUP_OPEN')
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.edit', $current_cycle->id) }}">Edit sign up</a>
                                @endif
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                            @elseif($current_cycle_sub_weeks)
                                <dd>You are signed up as a sub for the following weeks</dd>
                                @foreach($current_cycle_sub_weeks as $sub_week)
                                    <dd><a href="{{ route('sub.edit', $sub_week['deets']->pivot->id) }}">{{ $sub_week['week']->starts_at->toFormattedDateString() }}</a></dd>
                                @endforeach
                                <a class="btn btn-default btn-block" href="{{ route('sub.create', $current_cycle->id) }}">Sign up as sub</a>
                                <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                            @else
                                @if ($current_cycle->status() === 'SIGNUP_OPEN')
                                    <dd>Sign up is currently open until {{ $current_cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.create', $current_cycle->id) }}">Sign up</a>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $current_cycle->id) }}">Sign up as sub</a>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                                @elseif ($current_cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $current_cycle->id) }}">Sign up as sub</a>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                                @elseif ($current_cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess</dd>
                                <a class="btn btn-default btn-block" href="{{ route('sub.create', $current_cycle->id) }}">Sign up as sub</a>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                                @elseif ($current_cycle->status() === 'COMPLETED')
                                    <dd>Completed</dd>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                                @endif
                            @endif
                        </dl>
                    </div>
                </div>
            @endif
            @if(!empty($next_cycle))
                <div class="panel panel-default hidden">
                    <div class="panel-heading">Next Cycle</div>
                    <div class="panel-body">


                        <dl class="horizontal">
                            <dt>Name:</dt>
                            <dd>{{ $next_cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{{ $next_cycle->format }}</dd>

                            @if (!$next_cycle_signup )
                                <dt>Schedule</dt>
                                @foreach( $next_cycle->weeks as $week )
                                    <dd>{{ $week->starts_at->toFormattedDateString() }}</dd>
                                @endforeach
                            @endif
                            <dt>Current Status</dt>
                            @if ($next_cycle_signup)
                                @if (is_null($next_cycle_signup->pivot->team_id))
                                    <dd>You are signed up but not placed on a team yet.</dd>
                                @else
                                    <dd>You are on team: <em>TEAM NAME</em></dd>
                                @endif

                                @if ($next_cycle_signup->pivot->will_captain == true)
                                    <dd>You are willing to captain.</dd>
                                @else
                                    <dd>You are NOT willing to captain.</dd>
                                @endif
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        <th>Div1</th>
                                        <th>Div2</th>
                                        <th>Wk1</th>
                                        <th>Wk2</th>
                                        <th>Wk3</th>
                                        <th>Wk4</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $next_cycle_signup->pivot->div_pref_first }}</td>
                                        <td>{{ $next_cycle_signup->pivot->div_pref_second }}</td>
                                        @foreach($user->availability()->where('cycle_id', $next_cycle->id)->get() as $week)
                                            @if($week->pivot->attending)
                                                <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                                            @else
                                                <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </table>
                                @if ($next_cycle->status() === 'SIGNUP_OPEN')
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.edit', $next_cycle->id) }}">Edit sign up</a>
                                @endif
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                            @elseif($next_cycle_sub_weeks)
                                <dd>You are signed up as a sub for the following weeks</dd>
                                @foreach($next_cycle_sub_weeks as $sub_week)
                                    <dd><a href="{{ route('sub.edit', $sub_week['deets']->id) }}">{{ $sub_week['week']->starts_at->toFormattedDateString() }}</a></dd>
                                @endforeach
                                <a class="btn btn-default btn-block" href="{{ route('sub.create', $next_cycle->id) }}">Sign up as sub</a>
                                <a class="btn btn-info btn-block" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                            @else
                                @if ($next_cycle->status() === 'SIGNUP_OPEN')
                                    <dd>Sign up is currently open until {{ $next_cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.create', $next_cycle->id) }}">Sign up</a>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $next_cycle->id) }}">Sign up as sub</a>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                                @elseif ($next_cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                    <a class="btn btn-default btn-block" href="{{ route('sub.create', $next_cycle->id) }}">Sign up as sub</a>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                                @elseif ($next_cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess</dd>
                                <a class="btn btn-default btn-block" href="{{ route('sub.create', $next_cycle->id) }}">Sign up as sub</a>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                                @elseif ($next_cycle->status() === 'COMPLETED')
                                    <dd>Completed</dd>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                                @endif
                            @endif
                        </dl>
                    </div>
                </div>
            @endif
            </div>
            <div class="col-xs-12 col-md-6 col-md-pull-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile - <a href="{{ route('users.edit', $user->id) }}">Edit</a></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <h6>Name</h6>
                                <p>{{ ucwords($user->name) }}</p>
                                <h6>Nickname</h6>
                                <p>{{ ucwords($user->getNicknameOrShortName()) }}</p>
                                <h6>Email</h6>
                                <p>{{ $user->email }}</p>
                                <h6>Gender</h6>
                                <p>{{ $user->gender }}</p>
                                <h6>Birthday</h6>
                                <p>{{ $user->birthday->toFormattedDateString() }}</p>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h6>Cell Number</h6>
                                <p>{{ $user->cell_number }}</p>
                                <h6>Carrier</h6>
                                <p>{{ $user->mobile_carrier }}</p>
                                <h6>Dominant Hand</h6>
                                <p>{{ $user->dominant_hand }}</p>
                                <h6>Height</h6>
                                <p>{{ $user->heightString() }}</p>
                                <h6>Division Preference First</h6>
                                <p>{{ $user->division_preference_first }}</p>
                                <h6>Division Preference Second</h6>
                                <p>{{ $user->division_preference_second }}</p>
{{--                                 <h6>Season Pass</h6>
                                <p>Valid through {{ $user->season_pass_ends_on->toFormattedDateString() }}</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Ultimate History - <a href="{{ route('users.ultimate_history.edit', $user->id) }}">Edit</a></div>
                    <div class="panel-body">
                        @if ($user->ultimateHistory)
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <h6>Club affiliation</h6>
                                <p>{{ $user->ultimateHistory->club_affiliation }}</p>
                                <h6>Years played</h6>
                                <p>{{ $user->ultimateHistory->years_played }}</p>
                                <h6>Summary</h6>
                                <p>{{ $user->ultimateHistory->summary }}</p>
                                <h6>Favorite defensive position</h6>
                                <p>{{ $user->ultimateHistory->fav_defensive_position }}</p>
                                <h6>Favorite offensive position</h6>
                                <p>{{ $user->ultimateHistory->fav_offensive_position }}</p>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h6>Defensive or Offensive player</h6>
                                <p>{{ $user->ultimateHistory->def_or_off }}</p>
                                <h6>your best skill</h6>
                                <p>{{ $user->ultimateHistory->best_skill }}</p>
                                <h6>Skill you most want to improve</h6>
                                <p>{{ $user->ultimateHistory->skill_to_improve }}</p>
                                <h6>Your best throw</h6>
                                <p>{{ $user->ultimateHistory->best_throw }}</p>
                                <h6>Throw you most want to improve</h6>
                                <p>{{ $user->ultimateHistory->throw_to_improve }}</p>
                            </div>
                        </div>
                        @else
                            <div class="row">
                                <div class="col-xs-12">
                                    No history found.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection