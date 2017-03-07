<!-- ########## START FOCUS BANNER ########## -->
<div class="row">
    <div class="col-xs-12">
        <div>
            <img alt="FOCUS League" title="FOCUS League" src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-mobile">
        </div>
        <h5>
            Fostering Organized Competitive Ultimate Series
        </h5>
    </div>
</div>
<!-- ########## END FOCUS BANNER ########## -->
<!-- ########## START GAME STATUS ########## -->
<div class="row">
    <div class="col-xs-12">
        @if($current_cycle && $current_cycle->gameToday())
            <div    class="jumbotron"
                    style="background-color: #ffff99; margin-bottom:0" >
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
                        Games are on. However, if HSP is closed due to weather, games will be canceled. Please check back here and the <a href="https://twitter.com/FocusLeague">FOCUS League twitter feed</a> for the latest game status before heading out to the fields.
                    </p>
                @endif
                <div>
                    <iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="http://forecast.io/embed/#lat=29.638154&lon=-95.396883&name=Houston Sports Park (77045)"> </iframe>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- ########## END GAME STATUS ########## -->
<!-- ########## START CYCLE STATUS ########## -->
<div class = "row">
    <div class="col-xs-12">
    @if($current_cycle && $current_cycle->isSignupOpen())
        <div class="text-center" style="margin:1em 0;">
            <div class="alert alert-success">
                <a  href="{{ route('cycles.current') }}">
                    <h5 style="color: #fff; margin:0">
                        Sign up for Cycle {{ $current_cycle->name }} is now open!
                    </h5>
                </a>
            </div>
        </div>
    @elseif ($current_cycle)
        <div class="text-center" style="margin:1em 0;">
            <div class="alert alert-info">
                <a  href="{{ route('cycles.current') }}">
                    <h5 style="color: #fff; margin:0">
                    @if(auth()->check() && auth()->user()->current_cycle_signup())
                        Sign up for Cycle {{ $current_cycle->name }} closed at {{ $current_cycle->signup_closes_at->format('M j g:i a') }}.
                    @else
                        Sign up for Cycle {{ $current_cycle->name }} closed at {{ $current_cycle->signup_closes_at->format('M j g:i a') }} but you can still sign up as a sub.
                    @endif
                    </h5>
                </a>
            </div>
        </div>
    @endif
    @if($next_cycle)
        @if(!$current_cycle ||
         $current_cycle && !$current_cycle->isSignupOpen())
        <div class="text-center" style="margin:1em 0;">
            <div class="alert alert-warning">
                <a  href="{{ route('cycles.view', $next_cycle->id) }}">
                    <h5 style="color: #fff; margin:0">
                    Registration for Cycle {{ $next_cycle->name }} opens on {{ $next_cycle->signup_opens_at->format('M j') }}!
                    </h5>
                </a>
            </div>
        </div>
        @endif
    @endif
    </div>
</div>
<!-- ########## END CYCLE STATUS ########## -->
<!-- ########## START USER BUTTONS ROW ########## -->
<div class = "row">
    <div class="col-xs-12">
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
            @endif
            <p>
                <a  href="{{ route('sub.create', 'current') }}"
                    class ="btn btn-info btn-lg">
                        Sign up as a sub for Cycle {{ $current_cycle->name }}
                </a>
            </p>
        @endif
    @endif
    </div>
</div>
<!-- ########## END USER BUTTONS ROW ########## -->
<!-- ########## START INFO ROW ########## -->
<div class = "row">
    <div class = "col-xs-12 col-md-4">
        <div class="jumbotron how-it-works">
            <h4>
                How It Works
            </h4>
            <ol class="text-left" style="font-size: 20px;">
            <li>Register for a cycle</li>
            <li>Compete 3-4 weeks</li>
            <li>Rinse &amp; Repeat</li>
            </ol>
        </div>
    </div>
    <div class = "col-xs-12 col-md-4">
        @include('site.schedule')
    </div>
    <div class = "col-xs-12 col-md-4">
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
    </div>
</div>
<!-- ########## END INFO ROW ########## -->











