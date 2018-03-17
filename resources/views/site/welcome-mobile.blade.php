<!-- ########## START FOCUS BANNER ########## -->
<div class="row">
    <div class="col-12">
        <div>
            <img alt="FOCUS League" title="FOCUS League" src="{{ asset('assets/img/logo.png') }}" class="logo-welcome-mobile">
        </div>
        <h6>
            F<span class="text-secondary">ostering</span> O<span class="text-success">rganized</span> C<span class="text-danger">ompetitive</span> U<span class="text-warning">ltimate</span> S<span class="text-info">eries</span>
        </h6>
    </div>
</div>
<!-- ########## END FOCUS BANNER ########## -->
<!-- ########## START FOCUS ANNOUNCEMENT ########## -->

<!-- ########## END FOCUS ANNOUNCEMENT ########## -->
<!-- ########## START CYCLE STATUS ########## -->
<div class="row">
    <div class="col-12">
    @if($current_cycle && $current_cycle->gameToday())
        <div class="jumbotron" style="background-color: #ffff99;" >
            <p>
                Tonight
            </p>

            <p class="lead">
                Cycle {{$current_cycle->name}} - Wk {{ $current_cycle->gameToday()->week_index() }}
            </p>

            <time datetime="{{ $current_cycle->gameToday()->starts_at->format('Y-m-d') }}" class="icon">
                <em>{{ $current_cycle->gameToday()->starts_at->format('l') }}</em>
                <strong>{{ $current_cycle->gameToday()->starts_at->format('F') }}</strong>
                <span>{{ $current_cycle->gameToday()->starts_at->format('j') }}</span>
            </time>

            <p class="m-0">
                8 pm
            </p>

            @if($current_cycle->gameToday()->updated_at->isToday() && $current_cycle->gameToday()->updated_at->lt(Carbon::now()))
                <p class="m-0"><small>as of {{ $current_cycle->currentWeek()->updated_at->format('g:i A') }}</small></p>
            @elseif(Carbon::now()->gt(Carbon::parse('8 am')))
                <p class="m-0"><small>as of 8:00 am</small></p>
            @endif

            @if($current_cycle->gameToday()->isRainedOut())
                <h3 class="display-4"><small>Game <span class="text-danger">OFF</span></small></h3>
            @else
                <h3 class="display-4"><small>Game <span class="text-info">ON</span></small></h3>
            @endif

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

            <p class="m-0">
                <script type='text/javascript' src='https://darksky.net/widget/small/29.643475,-95.425376/us12/en.js?width=100%&height=150&title=Houston-Sports-Park&textColor=333333&bgColor=transparent&transparency=true&skyColor=333&fontFamily=Default&customFont=&units=us'></script>
            </p>

            <div class="row">
                <div class="col">
                    <a class="btn btn-primary w-100" href="{{ route('cycles.current') }}" style="text-decoration: none">Cycle Details</a>
                </div>
                @if(($current_cycle->status() == 'SIGNUP_OPEN'
                    || $current_cycle->status() == 'SIGNUP_CLOSED'
                    || $current_cycle->status() == 'IN_PROGRESS')
                )
                    @if(!$current_cycle->isSubbing(auth()->user()))
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
    @elseif($current_cycle && !$current_cycle->gameToday())
        <div class="jumbotron bg-info text-white">
            <h5>
                Next Game
            </h5>

            @if($current_cycle->currentWeek())
                <h3>
                    Cycle {{$current_cycle->name}} - Wk {{ $current_cycle->currentWeek()->week_index() }}
                </h3>

                <time datetime="{{ $current_cycle->currentWeek()->starts_at->format('Y-m-d') }}" class="icon">
                    <em style="color: red">{{ $current_cycle->currentWeek()->starts_at->format('l') }}</em>
                    <strong style="background-color: red">{{ $current_cycle->currentWeek()->starts_at->format('F') }}</strong>
                    <span>{{ $current_cycle->currentWeek()->starts_at->format('j') }}</span>
                </time>

                <h6>
                    {{ $current_cycle->currentWeek()->starts_at->format('g:i a') }}
                </h6>
            @else
                <h3>
                    Cycle {{$current_cycle->name}} - Wk 1
                </h3>

                <time datetime="{{ $current_cycle->weeks()->first()->starts_at->format('Y-m-d') }}" class="icon">
                    <em style="color: red">{{ $current_cycle->weeks()->first()->starts_at->format('l') }}</em>
                    <strong style="background-color: red">{{ $current_cycle->weeks()->first()->starts_at->format('F') }}</strong>
                    <span>{{ $current_cycle->weeks()->first()->starts_at->format('j') }}</span>
                </time>

                <h6>
                    {{ $current_cycle->weeks()->first()->starts_at->format('g:i a') }}
                </h6>
            @endif
            <div class="row m-1">
                <div class="col">
                    <a class="btn btn-primary w-100" href="{{ route('cycles.current') }}" style="text-decoration: none">Cycle Details</a>
                </div>
                @if(($current_cycle->status() == 'SIGNUP_OPEN'
                    || $current_cycle->status() == 'SIGNUP_CLOSED'
                    || $current_cycle->status() == 'IN_PROGRESS')
                )
                    @if(!$current_cycle->isSubbing(auth()->user()))
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
                        <time datetime="{{ $next_cycle->currentWeek()->starts_at->format('Y-m-d') }}" class="icon">
                            <em>{{ $next_cycle->signup_opens_at->format('l') }}</em>
                            <strong>{{ $next_cycle->signup_opens_at->format('F') }}</strong>
                            <span>{{ $next_cycle->signup_opens_at->format('j') }}</span>
                        </time>
                    </div>
                    <div class="col justify-content-center">
                        <h6>First Game</h6>
                        <time datetime="{{ $next_cycle->currentWeek()->starts_at->format('Y-m-d') }}" class="icon">
                            <em>{{ $next_cycle->weeks()->first()->starts_at->format('l') }}</em>
                            <strong>{{ $next_cycle->weeks()->first()->starts_at->format('F') }}</strong>
                            <span>{{ $next_cycle->weeks()->first()->starts_at->format('j') }}</span>
                        </time>
                    </div>
                </div>

                <div class="row m-1">
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
<div class="row">
    <div class="col-12">
        <p class="text-center">
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











