@extends('layouts.default')
@section('title','FOCUS League – Cycle {{ $cycle->name }}')

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
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Details</h4>
                    </div>
                    <div class="panel-body">
                        <dl class="horizontal">
                            <dt>Name:</dt>
                            <dd>{{ $cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>TBD</dd>
                            <dt>Current Status</dt>
                            @if ($cycle->status() === 'SIGNUP_OPENS_LATER')
                                <dd>Sign up opens at {{ $cycle->signup_opens_at->toDayDateTimeString() }}</dd>
                            @elseif ($cycle->status() === 'SIGNUP_OPEN')
                                <dd>Sign up is currently open until {{ $cycle->signup_closes_at->toDayDateTimeString() }}</dd>
                                <button class="btn btn-primary">Sign up</button>
                            @elseif ($cycle->status() === 'SIGNUP_CLOSED')
                                <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                <button class="btn btn-primary">Sign up as sub</button>
                            @elseif ($cycle->status() === 'IN_PROGRESS')
                                <dd>In progess</dd>
                                <button class="btn btn-primary">Sign up as sub</button>
                            @elseif ($cycle->status() === 'COMPLETED')
                                <dd>Completed</dd>
                            @endif
                        </dl>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Schedule</h4>
                    </div>
                    <div class="panel-body">
                        @foreach( $cycle->weeks as $week )
                            <p>{{ $week->starts_at->toFormattedDateString() }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Male Signups <span class="badge pull-right">{{ $cycle->signups()->male()->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Div1</th>
                                <th>Div2</th>
                                <th>Wk1</th>
                                <th>Wk2</th>
                                <th>Wk3</th>
                                <th>Wk4</th>
                            </tr>
                            @foreach( $cycle->signups()->male()->get() as $signup )
                                <tr>
                                    <td>{{ $signup->nickname }}</td>
                                    <td>{{ $signup->pivot->div_pref_first }}</td>
                                    <td>{{ $signup->pivot->div_pref_second }}</td>
                                    @foreach($signup->availability()->orderBy('pivot_week_id')->get() as $week)
                                        @if($week->pivot->attending)
                                            <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                                        @else
                                            <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr class="info">
                                <th class="text-center" colspan=3>Total</th>
                                <!-- <th></th> -->
                                <!-- <th></th> -->
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[0]->signups()->male()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[1]->signups()->male()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[2]->signups()->male()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[3]->signups()->male()->where('attending',true)->count() }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Male Subs</h4>
                    </div>
                    <div class="panel-body">
                        @for($i=0, $len=$cycle->weeks()->count(); $i < $len; $i++ )
                        <ul class="list-unstyled">
                            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }}</strong>&nbsp;<span class="badge pull-right">{{ $cycle->weeks[$i]->subs()->male()->count() }}</span></li>
                            @foreach($cycle->weeks[$i]->subs()->male()->get() as $sub)
                                <li>{{$sub->name}}</li>
                            @endforeach
                        </ul>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Female Signups <span class="badge pull-right">{{ $cycle->signups()->female()->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-striped">
                            <tr>
                                <th>Name</th>
                                <th>Div1</th>
                                <th>Div2</th>
                                <th>Wk1</th>
                                <th>Wk2</th>
                                <th>Wk3</th>
                                <th>Wk4</th>
                            </tr>
                            @foreach( $cycle->signups()->female()->get() as $signup )
                                <tr>
                                    <td>{{ $signup->nickname }}</td>
                                    <td>{{ $signup->pivot->div_pref_first }}</td>
                                    <td>{{ $signup->pivot->div_pref_second }}</td>
                                    @foreach($signup->availability()->orderBy('pivot_week_id')->get() as $week)
                                        @if($week->pivot->attending)
                                            <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                                        @else
                                            <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            <tr class="info">
                                <th class="text-center" colspan=3>Total</th>
                                <!-- <th></th> -->
                                <!-- <th></th> -->
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[0]->signups()->female()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[1]->signups()->female()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[2]->signups()->female()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks->sortBy('starts_at')[3]->signups()->female()->where('attending',true)->count() }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Female Subs</h4>
                    </div>
                    <div class="panel-body">
                        @for($i=0, $len=$cycle->weeks()->count(); $i < $len; $i++ )
                        <ul class="list-unstyled">
                            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }}</strong>&nbsp;<span class="badge pull-right">{{ $cycle->weeks[$i]->subs()->female()->count() }}</span></li>
                            @foreach($cycle->weeks[$i]->subs()->female()->get() as $sub)
                                <li>{{$sub->name}}</li>
                            @endforeach
                        </ul>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection