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
                                <p>{{ $user->birthday }}</p>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h6>Cell Number</h6>
                                <p>{{ $user->cell_number }}</p>
                                <h6>Dominant Hand</h6>
                                <p>{{ $user->dominant_hand }}</p>
                                <h6>Height</h6>
                                <p>{{ $user->height }}</p>
                                <h6>Division Preference First</h6>
                                <p>{{ $user->division_preference_first }}</p>
                                <h6>Division Preference Second</h6>
                                <p>{{ $user->division_preference_second }}</p>
                                <h6>Season Pass</h6>
                                <p>{{ $user->season_pass_ends_on }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Current Cycle</div>
                    <div class="panel-body">
                        Current Cycle Info
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Upcoming Cycles</div>
                    <div class="panel-body">
                        Upcoming Cycle Table
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Past Cycles</div>
                    <div class="panel-body">
                        Pasts Cycle Table
                    </div>
                </div>
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