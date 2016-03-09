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
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile - <a href="{{ route('users.edit', $user->id) }}">Edit</a></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <h6>Name</h6>
                                <p>{{ $user->name }}</p>
                                <h6>Nickname</h6>
                                <p>{{ $user->nickname }}</p>
                                <h6>Email</h6>
                                <p>{{ $user->email }}</p>
                                <h6>Gender</h6>
                                <p>{{ $user->gender }}</p>
                                <h6>Birthday</h6>
                                <p>{{ $user->getBirthdayString() }}</p>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h6>Cell Number</h6>
                                <p>{{ $user->cell_number }}</p>
                                <h6>Dominant Hand</h6>
                                <p>{{ $user->dominant_hand }}</p>
                                <h6>Height</h6>
                                <p>{{ $user->heightString() }}</p>
                                <h6>Division Preference First</h6>
                                <p>{{ $user->division_preference_first }}</p>
                                <h6>Division Preference Second</h6>
                                <p>{{ $user->division_preference_second }}</p>
                                <h6>Season Pass</h6>
                                <p>Valid through {{ $user->season_pass_ends_on->toFormattedDateString() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Balance</div>
                    <div class="panel-body">
                        Account Balance
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
            @if(!empty($current_cycle))
                <div class="panel panel-default">
                    <div class="panel-heading">Current Cycle</div>
                    <div class="panel-body">

                        <dl class="horizontal">
                            <dt>Name:</dt>
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
                                    <dd>You are on team: <em>TEAM NAME</em></dd>
                                @endif

                                @if ($current_cycle_signup->pivot->will_captain == true)
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
                                <th>Willing to captain?</th>
                            </tr>
                            <tr>
                                <td>{{ $current_cycle_signup->pivot->div_pref_first }}</td>
                                <td>{{ $current_cycle_signup->pivot->div_pref_second }}</td>


                                @foreach($user->availability()->where('cycle_id', $current_cycle->id)->get() as $week)
                                    @if($week->pivot->attending)
                                        <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                                    @else
                                        <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                                    @endif
                                @endforeach
                                <td>
                                    @if ($current_cycle_signup->pivot->will_captain)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
</table>
@if ($current_cycle->status() === 'SIGNUP_OPEN')
                                    <a class="btn btn-default btn-block" href="{{ route('cycle.signup.edit', $current_cycle->id) }}">Edit sign up</a>
@endif
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                            @else
                                @if ($current_cycle->status() === 'SIGNUP_OPEN')
                                    <dd>Sign up is currently open until {{ $current_cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                    <button class="btn btn-primary btn-block">Sign up</button>
                                    <button class="btn btn-default btn-block">Sign up as a sub</button>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                                @elseif ($current_cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                    <button class="btn btn-default btn-block">Sign up as a sub</button>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.view', $current_cycle->id) }}">Cycle Details</a>
                                @elseif ($current_cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess</dd>
                                    <button class="btn btn-default btn-block">Sign up as a sub</button>
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
                <div class="panel panel-default">
                    <div class="panel-heading">Next Cycle</div>
                    <div class="panel-body">


                        <dl class="horizontal">
                            <dt>Name:</dt>
                            <dd>{{ $current_cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>TBD</dd>

                            @if (!$current_cycle_signup )
                                <dt>Schedule</dt>
                                @foreach( $current_cycle->weeks as $week )
                                    <dd>{{ $week->starts_at->toFormattedDateString() }}</dd>
                                @endforeach
                            @endif
                            <dt>Current Status</dt>
                            @if ($current_cycle_signup)
                               {{ $current_cycle_signup->first()}}

                                <dd></dd>
<table class="table table-condensed table-striped">
                            <tr>
                                <th>Willing to captain?</th>
                                <th>Div1</th>
                                <th>Div2</th>
                                <th>Wk1</th>
                                <th>Wk2</th>
                                <th>Wk3</th>
                                <th>Wk4</th>
                            </tr>
                            <tr>
                                <td>
                                    @if ($current_cycle_signup->pivot->will_captain)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>{{ $current_cycle_signup->pivot->div_pref_first }}</td>
                                <td>{{ $current_cycle_signup->pivot->div_pref_second }}</td>


                                @foreach($user->availability()->where('cycle_id',$next_cycle->id)->get() as $week)
                                    @if($week->pivot->attending)
                                        <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                                    @else
                                        <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                                    @endif
                                @endforeach
                            </tr>
</table>
                            @else
                                @if ($current_cycle->status() === 'SIGNUP_OPEN')
                                    <dd>Sign up is currently open until {{ $current_cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                    <button class="btn btn-primary btn-block">Sign up</button>
                                    <button class="btn btn-default btn-block">Sign up as a sub</button>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.show', $current_cycle_signup->id) }}">Cycle Details</button>
                                @elseif ($current_cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                    <button class="btn btn-default btn-block">Sign up as a sub</button>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.show', $current_cycle_signup->id) }}">Cycle Details</button>
                                @elseif ($current_cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess</dd>
                                    <button class="btn btn-default btn-block">Sign up as a sub</button>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.show', $current_cycle_signup->id) }}">Cycle Details</button>
                                @elseif ($current_cycle->status() === 'COMPLETED')
                                    <dd>Completed</dd>
                                    <a class="btn btn-info btn-block" href="{{ route('cycles.show', $current_cycle_signup->id) }}">Cycle Details</button>
                                @endif
                            @endif
                        </dl>
                    </div>
                </div>
            @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Balance</div>
                    <div class="panel-body">
                        Account Balance
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection