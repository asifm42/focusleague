@extends('layouts.default')
@section('title','FOCUS League – Player Profile')
@section('styles')

@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md -6">
                <div class="panel panel-default">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">
                        'name' => {{ $user->name;}}'Asif Mohammed',
                        'nickname' => 'Sif',
                        'email' => 'asifm42@gmail.com',
                        'gender' => 'male',
                        'birthday' => '1980-02-23',
                        'cell_number' => '8326406042',
                        'dominant_hand' => 'right',
                        'height' => 70,
                        'division_preference' => "['mens' => 1, 'mixed'=>2, 'womens'=>0]",
                        'admin' => true,
                        'season_pass_ends_on' => '2016-10-15 11:59:59',
                        'password' => bcrypt('password'),
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md -6">
                <div class="panel panel-default">
                    <div class="panel-heading">Cycles</div>
                    <div class="panel-body">
                        Cycle Table
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop