@extends('layouts.default')
@section('title','FOCUS League – Player Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @if(auth()->user() == $user)
                    <h4>Your Profile & Ultimate History</h4>
                @elseif(auth()->user()->isAdmin())
                    <h4>{{$user->getNicknameOrShortName() }}'s Profile & Ultimate History</h4>
                @endif
            </div>
        </div>
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
    </div>
@endsection