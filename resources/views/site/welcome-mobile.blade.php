<!-- ########## START FOCUS BANNER ########## -->
<div class="row">
    <div class="col-12">
        <div>
            <img alt="FOCUS League" title="FOCUS League" src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-mobile">
        </div>
        <h5>
            Fostering Organized Competitive Ultimate Series
        </h5>
    </div>
</div>
<!-- ########## END FOCUS BANNER ########## -->
<!-- ########## START FOCUS ANNOUNCEMENT ########## -->
<div class="row">
    <div class="col-12">
        <div class="text-center mt-2 mb-2">
            <div class="alert alert-info">
                <h5 >
                    FOCUS League returns on<br>March 20th, 2018!
                </h5>
                <h5 class="m-0 mt-1">
                    Registration for Cycle 2018-01<br>opens on March 14th, 2018
                </h5>
            </div>
        </div>
    </div>
</div>
<!-- ########## END FOCUS ANNOUNCEMENT ########## -->
<!-- ########## START GAME STATUS ########## -->
<div class="row">
    <div class="col-12">
    @if($current_cycle && $current_cycle->gameToday())
        <div    class="jumbotron mb-0"
                style="background-color: #ffff99;" >
            <h5>
                Game Status for {{ Carbon::today()->format("l, F jS") }}<br />
                @if($current_cycle->currentWeek()->updated_at->isToday() && $current_cycle->currentWeek()->updated_at->lt(Carbon::now()))
                    <small>as of {{ $current_cycle->currentWeek()->updated_at->format('g:i A') }}</small>
                @elseif(Carbon::now()->gt(Carbon::parse('8 am')))
                    <small>as of 8:00 am</small>
                @endif
            </h5>
            @if($current_cycle->currentWeek()->hasStatus())
                {!! $current_cycle->currentWeek()->status() !!}
            @elseif($current_cycle->currentWeek()->isRainedOut())
                <p>
                    <span class="text-danger"><b>Game OFF</b></span>
                </p>
                <p>
                    Games are canceled due to weather.
                </p>
            @else
                <p>
                    <span class="text-success"><b>Game ON!</b></span>
                </p>
                <p>
                    However, if HSP is closed due to weather, games will be canceled. Please check back here and the <a href="https://twitter.com/FocusLeague">FOCUS League twitter feed</a> for the latest game status before heading out to the fields.
                </p>
            @endif
            <div>
                <iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="https://forecast.io/embed/#lat=29.638154&lon=-95.396883&name=Houston Sports Park (77045)"> </iframe>
            </div>
        </div>
    @endif
    </div>
</div>
<!-- ########## END GAME STATUS ########## -->
<!-- ########## START CYCLE STATUS ########## -->
<div class = "row">
    <div class="col-12">
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
    <div class="col-12">
    @if(auth()->check())
        <p>
            <a  href="{{ route('users.dashboard') }}"
                class ="btn btn-primary btn-lg" >
                    <i class="fa fa-tachometer"></i>&nbsp; Your Dashboard
            </a>
        </p>
        @if($current_cycle && !auth()->user()->current_cycle_signup())
                <p>
                    <a  href="{{ route('cycle.signup.create', 'current') }}"
                        class ="btn btn-primary btn-lg">
                        Sign up for Cycle {{ $current_cycle->name }}
                    </a>
                </p>
{{--             @if($current_cycle->isSignupOpen())
                <p>
                    <a  href="{{ route('cycle.signup.create', 'current') }}"
                        class ="btn btn-primary btn-lg">
                        Sign up for Cycle {{ $current_cycle->name }}
                    </a>
                </p>
            @endif --}}
{{--             <p>
                <a  href="{{ route('sub.create', 'current') }}"
                    class ="btn btn-info btn-lg">
                        Sign up as a sub for Cycle {{ $current_cycle->name }}
                </a>
            </p> --}}
        @endif
    @endif
    </div>
</div>
<!-- ########## END USER BUTTONS ROW ########## -->
<!-- ########## START INFO ROW ########## -->
<div class = "row">
    <div class="col-12 col-sm-6 mt-2 mb-2">
        <div class="card h-100 ">
            <div class="card-body d-flex">
                <div class="m-auto">
                    <h4>
                        The Mission
                    </h4>
                    <p class="lead">
                        To structure would-be Ultimate <span style="text-decoration: line-through;">Frisbee</span> pickup games into a league and increase the availability of competitive Ultimate in Houston.
                    </p>
                    <p>
                        <a  href="{{ route('site.faq') }}"
                            class="btn btn-secondary btn-lg">
                                Learn more
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 mt-2 mb-2">
        <div class="card h-100">
            <div class="card-body d-flex">
                <div class="m-auto">
                    <h4>
                        How It Works
                    </h4>
                    <ol class="text-left" style="font-size: 20px;">
                        <li>Register for a cycle</li>
                        <li>Compete 3-4 weeks</li>
                        <li>Rinse &amp; Repeat</li>
                    </ol>
                    <a  href="{{ route('site.faq') }}"
                        class="btn btn-secondary btn-lg">
                            FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-2 mb-2">
        @include('site.schedule')
    </div>
</div>

<!-- ########## END INFO ROW ########## -->











