<!-- ########## START FOCUS BANNER ########## -->
<div class="row mb-2">
    <div class="col-12">
        <div>
            <img alt="FOCUS League" title="FOCUS League" src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-desktop">
        </div>
        <h3>
            F<span style="opacity: 0.5;" class="text-info">ostering</span>
            O<span style="opacity: 0.5;" class="text-info">rganized</span>
            C<span style="opacity: 0.5;" class="text-info">ompetitive</span>
            U<span style="opacity: 0.5;" class="text-info">ltimate</span>
            S<span style="opacity: 0.5;" class="text-info">eries</span>
        </h3>
    </div>
</div>
<!-- ########## END FOCUS BANNER ########## -->
<!-- ########## START FOCUS ANNOUNCEMENT ########## -->
<div class="alert alert-warning" role="alert">
  <h2 class="alert-heading">FOCUS League returns March 5, 2020!</h2>
  <p>Aww yeah, time to dust off those cleats and start preppin' for the 2020 season. Come get some competitive reps at FOCUS League! First game on Thursday, March 5th, 2020. Registration opens on Friday, February 28th.</p>
</div>
<!-- ########## END FOCUS ANNOUNCEMENT ########## -->
<!-- ########## START GAME STATUS ########## -->
<div class="row">
    <div class="col-12">
    @if($current_cycle && $current_cycle->gameToday())
        <div class="jumbotron" style="background-color: #ffff99;" >

            <h3>
                Cycle {{$current_cycle->name}} - Wk {{ $current_cycle->gameToday()->week_index() }}
            </h3>
            <h4>
                <small>8 pm Tonight</small>
            </h4>

            @component('site.calendar-icon', [
                'date' => $current_cycle->gameToday()->starts_at,
                'class' => 'icon-lg'
            ])
            @endcomponent

            @if($current_cycle->gameToday()->isRainedOut())
                <h3 class="display-4 mb-0"><small>Game <span class="text-danger">OFF</span></small></h3>
            @else
                <h3 class="display-4 mb-0"><small>Game <span class="text-info">ON</span></small></h3>
            @endif

            <h5 class="text-muted">
                @if($current_cycle->gameToday()->updated_at->isToday() && $current_cycle->gameToday()->updated_at->lt(Carbon::now()))
                    <small>as of {{ $current_cycle->gameToday()->updated_at->format('g:i A') }}</small>
                @elseif(Carbon::now()->gt(Carbon::parse('8 am')))
                    <small>as of 8:00 am</small>
                @endif
            </h5>

            @if($current_cycle->gameToday()->hasStatus())
                {!! $current_cycle->gameToday()->status() !!}
            @elseif($current_cycle->gameToday()->isRainedOut())
                <p class="m-0">
                    Games are canceled due to weather.
                </p>
            @else
                <p class="m-0">
                    However, if HSP is closed due to weather, games will be canceled. Please check back here and the <a href="https://twitter.com/FocusLeague">FOCUS League twitter feed</a> for the latest game status before heading out to the fields.
                </p>
            @endif
            <p>
                {{-- <iframe id="forecast_embed" type="text/html" frameborder="0" height="245" width="100%" src="https://forecast.io/embed/#lat=29.638154&lon=-95.396883&name=Houston Sports Park (77045)"> </iframe> --}}

                {{-- <script type='text/javascript' src='https://darksky.net/widget/small/29.6379651,-95.3959319/us12/en.js?width=100%&height=150&title=Houston Sports Park&textColor=333333&bgColor=transparent&transparency=true&skyColor=333&fontFamily=Default&customFont=&units=us'></script> --}}

                <script type='text/javascript' src='https://darksky.net/widget/graph-bar/29.637965,-95.395932/us12/en.js?width=100%&height=400&title=Houston Sports Park&textColor=333333&bgColor=transparent&transparency=true&skyColor=undefined&fontFamily=Default&customFont=&units=us&timeColor=333333&tempColor=333333&currentDetailsOption=true'></script>
            </p>
            <div class="row">
                <div class="col">
                    <a class="btn btn-primary w-100" href="{{ route('cycles.current') }}" style="text-decoration: none">Cycle Details</a>
                </div>
                @if(($current_cycle->status() == 'SIGNUP_OPEN'
                    || $current_cycle->status() == 'SIGNUP_CLOSED'
                    || $current_cycle->status() == 'IN_PROGRESS'))
                    @if(auth()->check())
                        @if($current_cycle->signups->contains(auth()->user()))
                           <div class="col">
                                <a class="btn btn-primary w-100" href="{{ route('cycle.signup.edit', $current_cycle->id) }}" style="text-decoration: none">Edit sign-up</a>
                            </div>
                        @elseif($current_cycle->isSubbing(auth()->user()))
                           <div class="col">
                                <a class="btn btn-primary w-100" href="{{ route('cycle.subs.edit', 'current') }}" style="text-decoration: none">Edit sign-up</a>
                            </div>
                        @endif
                    @else
                       <div class="col">
                            <a class="btn btn-primary w-100" href="{{ route('cycle.signup.create', 'current') }}" style="text-decoration: none">Sign up</a>
                        </div>
                    @endif
                @endif
                @if($current_cycle->status() == 'SIGNUP_OPEN')
                    <span class='text-center w-100 mt-1'><small>Sign-up closes at {{ $current_cycle->signup_closes_at->format('M j g:i a') }}</small></span>
                @elseif($current_cycle->status() == 'SIGNUP_CLOSED')
                    <span class='text-center w-100 mt-1'><small>Taking late signups and subs</small></span>
                @elseif($current_cycle->status() == 'IN_PROGRESS')
                    <span class='text-center w-100 mt-1'><small>Taking sub signups</small></span>
                @endif
            </div>
        </div>
    @endif
    </div>
</div>
<!-- ########## END GAME STATUS ########## -->
<!-- ########## START CYCLE STATUS ########## -->

<div class = "row justify-content-sm-center">
    <div class="col-12 col-sm-6 col-md-6">
    @if($current_cycle && !$current_cycle->gameToday())
        <div class="text-center mx-0 my-1">
            <div class="alert alert-info">
                <h5>
                    Next Game
                </h5>
                @if($current_cycle->currentWeek())
                    <h3>
                        Cycle {{$current_cycle->name}} - Wk {{ $current_cycle->currentWeek()->week_index() }}
                    </h3>

                    @component('site.calendar-icon', [
                        'date' => $current_cycle->currentWeek()->starts_at,
                        'color' => 'red'
                    ])
                    @endcomponent

                    <h6>
                        {{ $current_cycle->currentWeek()->starts_at->format('g:i a') }}
                    </h6>
                @else
                    <h3>
                        Cycle {{$current_cycle->name}} - Wk 1
                    </h3>

                    @component('site.calendar-icon', [
                        'date' => $current_cycle->weeks()->first()->starts_at,
                        'color' => 'red'
                    ])
                    @endcomponent

                    <h6>
                        {{ $current_cycle->weeks()->first()->starts_at->format('g:i a') }}
                    </h6>
                @endif
                <div class="row m-1 justify-content-sm-center">
                    <div class="col">
                        <a class="btn btn-primary w-100" href="{{ route('cycles.current') }}" style="text-decoration: none">Cycle Details</a>
                    </div>
                    @if($current_cycle->status() == 'SIGNUP_OPEN'
                        || $current_cycle->status() == 'SIGNUP_CLOSED'
                        || $current_cycle->status() == 'IN_PROGRESS')

                        @if (auth()->check() && $current_cycle->signups->contains(auth()->user()))
                           <div class="col">
                                <a class="btn btn-primary w-100" href="{{ route('cycle.signup.edit', $current_cycle->id) }}" style="text-decoration: none">Edit sign-up</a>
                            </div>
                        @elseif (auth()->check() && $current_cycle->isSubbing(auth()->user()))
                           <div class="col">
                                <a class="btn btn-primary w-100" href="{{ route('cycle.subs.edit', 'current') }}" style="text-decoration: none">Edit sign-up</a>
                            </div>
                        @else
                           <div class="col">
                                <a class="btn btn-primary w-100" href="{{ route('cycle.signup.create', 'current') }}" style="text-decoration: none">Sign up</a>
                            </div>
                        @endif
                    @endif
                    @if($current_cycle->status() == 'SIGNUP_OPEN')
                        <span class='text-center w-100 mt-1'><small>Sign-up closes at {{ $current_cycle->signup_closes_at->format('M j g:i a') }}</small></span>
                    @elseif($current_cycle->status() == 'SIGNUP_CLOSED')
                        <span class='text-center w-100 mt-1'><small>Taking late signups and subs</small></span>
                    @elseif($current_cycle->status() == 'IN_PROGRESS')
                        <span class='text-center w-100 mt-1'><small>Taking sub signups</small></span>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if($next_cycle)
        @if(!$current_cycle ||
         $current_cycle && !$current_cycle->isSignupOpen())
        <div class="text-center mx-0 my-1">
            <div class="alert alert-warning">
                <h5>
                    Next Cycle
                </h5>
                <h3>
                Cycle {{ $next_cycle->name }}
                </h3>
                <div class="row">
                    <div class="col justify-content-center">
                        <h6>Sign-up Opens</h6>

                        @component('site.calendar-icon', [
                            'date' => $next_cycle->signup_opens_at
                        ])
                        @endcomponent

                    </div>
                    <div class="col justify-content-center">
                        <h6>First Game</h6>

                        @component('site.calendar-icon', [
                            'date' => $next_cycle->weeks()->first()->starts_at
                        ])
                        @endcomponent

                    </div>
                </div>

                <div class="row m-1 justify-content-sm-center">
                    <div class="col">
                        <a class="btn btn-primary w-100" href="{{ route('cycles.view', $next_cycle->id) }}" style="text-decoration: none">Cycle Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
    </div>
</div>
<!-- ########## END CYCLE STATUS ########## -->
<!-- ########## START USER BUTTONS ROW ########## -->
@if(auth()->check())
<div class = "row">
    <div class="col-12">
        <p>
            <a  href="{{ route('users.dashboard') }}"
                class ="btn btn-primary btn-lg" >
                    <i class="fa fa-tachometer"></i>&nbsp; Your Dashboard
            </a>
        </p>
    </div>
</div>
@endif
<!-- ########## END USER BUTTONS ROW ########## -->
<!-- ########## START INFO ROW ########## -->
<div class="row">
    <div class="col mt-2 mb-2">
        <div class="card h-100">
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

    <div class="col mt-2 mb-2">
            @include('site.schedule')
    </div>

    <div class="col mt-2 mb-2">
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
<!-- ########## END INFO ROW ########## -->
