@extends('layouts.default')
@section('title','FOCUS League – Player Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @if(auth()->user() == $user)
                    <h4>Your Dashboard</h4>
                    <p>Overview of your account.</p>
                @elseif(auth()->user()->isAdmin())
                    <h4>{{$user->getNicknameOrShortName() }}'s Dashboard</h4>
                    <p>Overview of {{ $user->name }}'s account.</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm my-2">
                <div class="card">
                    <div class="card-header">Balance</div>
                    <div class="card-body pb-2">
                        @if ($balance > 0)
                            <h6 class="text-center"><small class="text-uppercase">You owe</small></h6>
                            <h3 class="text-center mb-4 text-danger">${{ $user->getBalanceInDollars() }}</h3>
                            <h6>You can pay via the following methods:</h6>
                            @component('site.payment_methods', ['balance' => $user->getBalanceInDollars()])
                            @endcomponent
                        @elseif ($balance == 0)
                            <h6 class="text-center"><small class="text-uppercase">Your balance</small></h6>
                            <h3 class="text-center mb-4">$0.00</h3>
                            <h5 class="text-center text-success">Thank you for being current!</h5>
                        @elseif ($balance < 0)
                            <h6 class="text-center"><small class="text-uppercase">Your credit</small></h6>
                            <h3 class="text-center mb-4 text-info">${{ $user->getBalanceInDollars() }}</h3>
                            <h6 class="text-center text-muted">auto applied to your next charge</h6>
                        @endif
                        @if(auth()->user() == $user)
                            <a href="{{ route('balance.details') }}" class="btn btn-secondary btn-block">See balance details</a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('users.balance', $user->id) }}" class="btn btn-secondary btn-block">See balance details</a>
                        @else
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty($current_cycle))
            <div class="col-12 col-sm my-2">
                <div class="card">
                    <div class="card-header">Current Cycle</div>
                    <div class="card-body">

                        <dl class="mb-0">
                            <dt>Name</dt>
                            <dd>{{ $current_cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{{ $current_cycle->format }}</dd>

                            @if (!$current_cycle_signup )
                                <dt>Schedule</dt>
                                @foreach( $current_cycle->weeks as $key=>$week )
                                    <dd>Wk{{ $key+1 }} - {{ $week->starts_at->toFormattedDateString() }}</dd>
                                @endforeach
                            @endif
                            <dt>Status</dt>

                            @include('cycles.status-card-body', ['cycle' => $current_cycle, 'cycle_signup' => $current_cycle_signup, 'sub_weeks' => $current_cycle_sub_weeks])

                        </dl>
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($next_cycle))
            <div class="col-12 col-sm my-2">
                <div class="card">
                    <div class="card-header">Next Cycle</div>
                    <div class="card-body">
                        <dl class="mb-0">
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
                            <dt>Status</dt>
                            @if ($next_cycle->status() === 'SIGNUP_OPENS_LATER')
                                <dd>Sign up opens on {{ $next_cycle->signup_opens_at->format('D, M j, Y') }}</dd>
                                <a class="btn btn-info btn-block mt-3" href="{{ route('cycles.view', $next_cycle->id) }}">Cycle Details</a>
                            @elseif ($next_cycle->status() === 'SIGNUP_OPEN')
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
                        </dl>
                    </div>
                </div>
            </div>
            @endif
            @if(empty($current_cycle) && empty($next_cycle))
                <div class="col-12 col-sm my-2">
                    @include('site.schedule')
                </div>
            @endif
        </div>
        @if(auth()->user()->isAdmin())
            <div class="row">
                <div class="col-12 col-sm">
                    <div class="card mt-2 mb-2">
                        <div class="card-header">Profile - <a href="{{ route('users.edit', $user->id) }}">Edit</a></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <h6 class="font-weight-bold text-muted">Name</h6>
                                    <p>{{ ucwords($user->name) }}</p>
                                    <h6 class="font-weight-bold text-muted">Nickname</h6>
                                    <p>{{ ucwords($user->getNicknameOrShortName()) }}</p>
                                    <h6 class="font-weight-bold text-muted">Email</h6>
                                    <p>{{ $user->email }}</p>
                                    <h6 class="font-weight-bold text-muted">Gender</h6>
                                    <p>{{ $user->gender }}</p>
                                    <h6 class="font-weight-bold text-muted">Birthday</h6>
                                    <p>{{ $user->birthday->toFormattedDateString() }}</p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h6 class="font-weight-bold text-muted">Cell Number</h6>
                                    <p>{{ $user->cell_number }}</p>
                                    <h6 class="font-weight-bold text-muted">Carrier</h6>
                                    <p>{{ $user->mobile_carrier }}</p>
                                    <h6 class="font-weight-bold text-muted">Dominant Hand</h6>
                                    <p>{{ $user->dominant_hand }}</p>
                                    <h6 class="font-weight-bold text-muted">Height</h6>
                                    <p>{{ $user->heightString() }}</p>
                                    <h6 class="font-weight-bold text-muted">Division Preference First</h6>
                                    <p>{{ $user->division_preference_first }}</p>
                                    <h6 class="font-weight-bold text-muted">Division Preference Second</h6>
                                    <p>{{ $user->division_preference_second }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm">
                    <div class="card mt-2 mb-2">
                        <div class="card-header">Ultimate History - <a href="{{ route('users.ultimate_history.edit', $user->id) }}">Edit</a></div>
                        <div class="card-body">
                            @if ($user->ultimateHistory)
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <h6 class="font-weight-bold text-muted">Club affiliation</h6>
                                    <p>{{ $user->ultimateHistory->club_affiliation }}</p>
                                    <h6 class="font-weight-bold text-muted">Years played</h6>
                                    <p>{{ $user->ultimateHistory->years_played }}</p>
                                    <h6 class="font-weight-bold text-muted">Summary</h6>
                                    <p>{{ $user->ultimateHistory->summary }}</p>
                                    <h6 class="font-weight-bold text-muted">Favorite defensive position</h6>
                                    <p>{{ $user->ultimateHistory->fav_defensive_position }}</p>
                                    <h6 class="font-weight-bold text-muted">Favorite offensive position</h6>
                                    <p>{{ $user->ultimateHistory->fav_offensive_position }}</p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <h6 class="font-weight-bold text-muted">Defensive or Offensive player</h6>
                                    <p>{{ $user->ultimateHistory->def_or_off }}</p>
                                    <h6 class="font-weight-bold text-muted">Your best skill</h6>
                                    <p>{{ $user->ultimateHistory->best_skill }}</p>
                                    <h6 class="font-weight-bold text-muted">Skill you most want to improve</h6>
                                    <p>{{ $user->ultimateHistory->skill_to_improve }}</p>
                                    <h6 class="font-weight-bold text-muted">Your best throw</h6>
                                    <p>{{ $user->ultimateHistory->best_throw }}</p>
                                    <h6 class="font-weight-bold text-muted">Throw you most want to improve</h6>
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
        @endif
        </div>
    </div>
@endsection