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
                                    <a class="btn btn-primary btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
                                @elseif ($cycle->status() === 'SIGNUP_CLOSED')
                                    <dd>Sign up is currently closed. You can still sign up as a sub.</dd>
                                    <a class="btn btn-primary btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
                                @elseif ($cycle->status() === 'IN_PROGRESS')
                                    <dd>In progess</dd>
                                    <a class="btn btn-primary btn-block" href="{{ route('sub.create', $cycle->id) }}">Sign up as sub</a>
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
                            <li>{{'Week ' . ($i+1) . ' - ' . $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</li>
                        @endfor
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Male Signups <span class="badge pull-right">{{ $cycle->signups()->male()->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-striped table-responsive">
                            <tr class="text-center">
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
                                    <td>{{ $signup->getNicknameOrFirstName() }}</td>
                                    {{-- <td class="">{{ strtolower($signup->pivot->div_pref_first) }}</td> --}}
                                    {{-- <td class="">{{ strtolower($signup->pivot->div_pref_second) }}</td> --}}
                                    <td class="text-center">
                                        @if(strtolower($signup->pivot->div_pref_first) === 'mens')
                                            <i class="fa fa-male fa-fw text-primary"></i>
                                        @elseif(strtolower($signup->pivot->div_pref_first) === 'mixed')
                                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(strtolower($signup->pivot->div_pref_second) === 'mens')
                                            <i class="fa fa-male fa-fw text-primary"></i>
                                        @elseif(strtolower($signup->pivot->div_pref_second) === 'mixed')
                                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                                        @endif
                                    </td>
                                    @foreach($signup->availability()->where('cycle_id',$cycle->id)->orderBy('pivot_week_id')->get() as $week)
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
                                <th class="text-center">{{$cycle->weeks[0]->signups()->male()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks[1]->signups()->male()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks[2]->signups()->male()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks[3]->signups()->male()->where('attending',true)->count() }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Female Signups <span class="badge pull-right">{{ $cycle->signups()->female()->count() }}</span></h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed table-striped table-responsive">
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
                                    <td>{{ $signup->getNicknameOrFirstName() }}</td>
                                    {{-- <td>{{  strtolower($signup->pivot->div_pref_first) }}</td> --}}
                                    {{-- <td>{{  strtolower($signup->pivot->div_pref_second) }}</td> --}}
                                    <td class="text-center">
                                        @if(strtolower($signup->pivot->div_pref_first) === 'womens')
                                            <i class="fa fa-female fa-fw text-info"></i>
                                        @elseif(strtolower($signup->pivot->div_pref_first) === 'mixed')
                                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(strtolower($signup->pivot->div_pref_second) === 'womens')
                                            <i class="fa fa-female fa-fw text-info"></i>
                                        @elseif(strtolower($signup->pivot->div_pref_second) === 'mixed')
                                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                                        @endif
                                    </td>
                                    @foreach($signup->availability()->where('cycle_id',$cycle->id)->orderBy('pivot_week_id')->get() as $week)
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
                                <th class="text-center">{{$cycle->weeks[0]->signups()->female()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks[1]->signups()->female()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks[2]->signups()->female()->where('attending',true)->count() }}</th>
                                <th class="text-center">{{$cycle->weeks[3]->signups()->female()->where('attending',true)->count() }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Male Subs</h4>
                    </div>
                    <div class="panel-body">
                        @for($i=0, $len=$cycle->weeks()->count(); $i < $len; $i++ )
                        <ul class="list-unstyled">
                            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }}</strong>&nbsp;<span class="badge pull-right">{{ $cycle->weeks[$i]->subs()->male()->count() }}</span></li>
                            @foreach($cycle->weeks[$i]->subs()->male()->get() as $sub)
                                <li>{{$sub->getNicknameOrFirstName()}}</li>
                            @endforeach
                        </ul>
                        @endfor
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
                                <li>{{$sub->getNicknameOrFirstName()}}</li>
                            @endforeach
                        </ul>
                        @endfor
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection