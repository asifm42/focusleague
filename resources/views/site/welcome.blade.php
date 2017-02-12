@extends('layouts.default')
@section('title','FOCUS League – Welcome')
@section('styles')
<style>

time.icon
{
  font-size: 0.8em; /* change icon size */
  display: inline-block;
  position: relative;
  width: 6.5em;
  height: 7.5em;
  background-color: #fff;
  border-radius: 0.6em;
  border: 1px solid #2196f3;
  /*border: 1px solid #c1c1c1;*/
  /*box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;*/
  overflow: hidden;
}

time.icon *
{
  display: block;
  width: 100%;
  font-size: 1em;
  font-weight: bold;
  font-style: normal;
  text-align: center;
}

time.icon strong
{
  position: absolute;
  top: 0;
  padding: 0.4em 0;
  color: #fff;
  background-color: #2196f3;
  /*border-bottom: 1px dashed #f37302;*/
  /*box-shadow: 0 2px 0 #fd9f1b;*/
}

time.icon em
{
  position: absolute;
  bottom: 0.2em;
  color: #2196f3;
}

time.icon span
{
  font-size: 2.25em;
  letter-spacing: -0.05em;
  padding-top: 1em;
  color: #2f2f2f;
}

span.event,
span.event-xs  {
    display: inline-block;
    line-height: 4em;
    vertical-align: top;
    padding-left: 20px;
    font-size: 1.5em;
}
span.event-xs {
    line-height: 6em;
    font-size: 1em;
}

span.
</style>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="text-center hidden-md hidden-lg">
                    <div>
                        <img alt="FOCUS League" title="FOCUS League" src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-mobile">
                    </div>
                    <h5>
                        Fostering Organized Competitive Ultimate Series
                    </h5>
                    <!-- <h5><span class = "emphasize">F</span>ostering <span class = "emphasize">O</span>rganized <strong>C</strong>ompetitive <strong>U</strong>ltimate <strong>S</strong>eries</h5> -->

                    <div class="text-center">
                        <div class="jumbotron">
                            <h4>
                                The Mission
                            </h4>
                            <p>
                                To structure would-be Ultimate <span style="text-decoration: line-through;">Frisbee</span> pickup games into a league and increase the availability of competitive Ultimate in Houston.
                            </p>
                            <p>
                                <a  href="{{ route('site.faq') }}"
                                    class="btn btn-default btn-lg">
                                        Learn more
                                </a>
                            </p>
                        </div>
                    </div>

                    @if($current_cycle && $current_cycle->gameToday())
                        <div    class="jumbotron"
                                style="background-color: #ffff99;" >
                            <h4>
                                Game Status for {{ Carbon::today()->format("l, F jS") }}
                            </h4>
                            @if($current_cycle->currentWeek()->hasStatus())
                                {!! $current_cycle->currentWeek()->status() !!}
                            @elseif($current_cycle->currentWeek()->isRainedOut())
                                <p>
                                    Games are canceled due to weather.
                                </p>
                            @else
                                <p>
                                    Games are on. However, if HSP is closed due to weather, games will be canceled. HSP will communicate park closure via their <a href="http://www.houstonsportspark.com">website</a> and <a href="https://twitter.com/HoustonSportsPk?ref_src=twsrc%5Etfw">twitter feed</a>. Check one of those resources before heading to the fields.
                                </p>
                            @endif
                            <div>
                                <iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat=29.638154&lon=-95.396883&name=Houston Sports Park (77045)"> </iframe>
                            </div>
                        </div>
                    @endif

                    @if(auth()->check())
                        <p>
                            <a  href="{{ route('users.dashboard') }}"
                                class ="btn btn-primary btn-lg" >
                                    <i class="fa fa-tachometer"></i>&nbsp; Your Dashboard
                            </a>
                        </p>
                        @if($current_cycle && !auth()->user()->current_cycle_signup())
                            @if($current_cycle->isSignupOpen())
                                <p>
                                    <a  href="{{ route('cycle.signup.create', 'current') }}"
                                        class ="btn btn-primary btn-lg">
                                            Sign up for Cycle {{ $current_cycle->name }}
                                    </a>
                                </p>
                            @else
                                <h5 class="text-info">
                                    Sign up for Cycle {{ $current_cycle->name }} closed at {{ $current_cycle->signup_closes_at->format('M j g:i a') }} but you can still sign up as a sub.
                                </h5>
                            @endif
                            <p>
                                <a  href="{{ route('sub.create', 'current') }}"
                                    class ="btn btn-info btn-lg">
                                        Sign up as a sub for Cycle {{ $current_cycle->name }}
                                </a>
                            </p>
                        @endif
                    @else
                        @if($current_cycle && $current_cycle->isSignupOpen())
                            <h5 class="text-primary">
                                Sign up for Cycle {{ $current_cycle->name }} is now open!
                            </h5>
                        @elseif ($current_cycle)
                            <h5 class="text-info">
                                Sign up for Cycle {{ $current_cycle->name }} closed at {{ $current_cycle->signup_closes_at->format('M j g:i a') }} but you can still sign up as a sub.
                            </h5>
                        @endif
                        <p>
                            <a  href="{{ route('sessions.create') }}"
                                class="btn btn-primary btn-lg"><i class="fa fa-sign-in"></i>&nbsp; Sign in</a>
                        </p>
                    @endif

                    @if($next_cycle)
                        <h5 class="text-info">
                            Registration for Cycle {{ $next_cycle->name }} opens on {{ $next_cycle->signup_opens_at->format('M j') }}!
                        </h5>
                    @endif

                    @include('site.schedule')
                </div>
                <div class="text-center hidden-xs hidden-sm">
                    <div>
                        <img src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-desktop">
                    </div>
                    <h3>
                        Fostering Organized Competitive Ultimate Series
                    </h3>

                    <div class="text-center">
                        <div class="jumbotron">
                            <h4>
                                The Mission
                            </h4>
                            <p>
                                To structure would-be Ultimate <span style="text-decoration: line-through;">Frisbee</span> pickup games into a league and increase the availability of competitive Ultimate in Houston.
                            </p>
                            <p>
                                <a  href="{{ route('site.faq') }}"
                                    class="btn btn-default btn-lg">
                                        Learn more
                                </a>
                            </p>
                        </div>
                    </div>
                    @if($current_cycle && $current_cycle->gameToday())
                    <div class="jumbotron" style="background-color: #ffff99;" >
                            <h3>
                                Game Status for {{ Carbon::today()->format("l, F jS") }}
                            </h3>
                            @if($current_cycle->currentWeek()->hasStatus())
                                {!! $current_cycle->currentWeek()->status() !!}
                            @elseif($current_cycle->currentWeek()->isRainedOut())
                                <p>
                                    Games are canceled due to weather.
                                </p>
                            @else
                                <p>
                                    Games are on. However, if HSP is closed due to weather, games will be canceled. HSP will communicate park closure via their <a href="http://www.houstonsportspark.com">website</a> and <a href="https://twitter.com/HoustonSportsPk?ref_src=twsrc%5Etfw">twitter feed</a>. Check one of those resources before heading to the fields.
                                </p>
                            @endif
                        <div>
                            <iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat=29.638154&lon=-95.396883&name=Houston Sports Park (77045)"> </iframe>
                        </div>
                    </div>
                    @endif

                    @if(auth()->check())
                        <p>
                            <a  href="{{ route('users.dashboard') }}"
                                class ="btn btn-primary btn-lg" >
                                    <i class="fa fa-tachometer"></i>&nbsp; Your Dashboard
                            </a>
                        </p>
                        @if($current_cycle && !auth()->user()->current_cycle_signup())
                            @if($current_cycle->isSignupOpen())
                                <p>
                                    <a  href="{{ route('cycle.signup.create', 'current') }}"
                                        class ="btn btn-primary btn-lg">
                                        Sign up for Cycle {{ $current_cycle->name }}
                                    </a>
                                </p>
                            @else
                                <h4 class="text-info">Sign up for Cycle {{ $current_cycle->name }} closed at {{ $current_cycle->signup_closes_at->format('M j g:i a') }} but you can still sign up as a sub.</h4>
                            @endif
                            <p>
                                <a  href="{{ route('sub.create', 'current') }}"
                                    class ="btn btn-info btn-lg">
                                        Sign up as a sub for Cycle {{ $current_cycle->name }}
                                </a>
                            </p>
                        @endif
                    @else
                        @if($current_cycle && $current_cycle->isSignupOpen())
                            <h4 class="text-primary">
                                Sign up for Cycle {{ $current_cycle->name }} is now open!
                            </h4>
                        @elseif ($current_cycle)
                            <h4 class="text-info">
                                Sign up for Cycle {{ $current_cycle->name }} closed at {{ $current_cycle->signup_closes_at->format('M j g:i a') }} but you can still sign up as a sub.
                            </h4>
                        @endif
                        <p>
                            <a  href="{{ route('sessions.create', 2) }}"
                                class="btn btn-primary btn-lg">
                                    <i class="fa fa-sign-in"></i>&nbsp; Sign in
                            </a>
                        </p>
                    @endif
                    @if($next_cycle)
                        <h4 class="text-info">
                            Registration for Cycle {{ $next_cycle->name }} opens on {{ $next_cycle->signup_opens_at->format('M j') }}!
                        </h4>
                    @endif

                    @include('site.schedule')
                </div>
            </div>
        </div>
    </div>
@endsection