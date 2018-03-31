<nav class="navbar navbar-expand-md navbar-light justify-content-between">

        <!-- Brand and toggle get grouped for better mobile display -->
        <a class="navbar-brand" href="{{ route('site.home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="FOCUS League" title="FOCUS League" class="logo-navbar"></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-1" aria-controls="navbar-collapse-1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1">

            <ul class="navbar-nav mr-auto">
                <li class="{{ active_class(if_uri_pattern(['/'], 'active')) }} nav-item"><a href="{{ route('site.home') }}" class="nav-link"><i class="fa fa-fw fa-home"></i>&nbsp; Home</a></li>
                <li class="{{ active_class(if_uri_pattern(['news'], 'active')) }} nav-item"><a href="{{ route('site.news') }}" class="nav-link"><i class="fa fa-fw fa-newspaper-o"></i>&nbsp; News</a></li>
                <li class="{{ active_class(if_uri_pattern(['faq'], 'active')) }} nav-item"><a href="{{ route('site.faq') }}" class="nav-link"><i class="fa fa-fw fa-question"></i>&nbsp; FAQ</a></li>
                <li class="{{ active_class(if_uri_pattern(['contact'], 'active')) }} nav-item"><a href="{{ route('contact.create') }}" class="nav-link"><i class="fa fa-fw fa-envelope"></i>&nbsp; Contact</a></li>
        @if(! auth()->check())
                <li class="nav-item d-md-none {{ active_class(if_uri_pattern(['signin'], ' active')) }}"><a href="{{ route('sessions.create') }}" class="nav-link"><i class="fa fa-sign-in fa-fw"></i>&nbsp; Sign In</a></li>
                <li class="nav-item d-md-none {{ active_class(if_uri_pattern(['signup'], ' active')) }}"><a href="{!! route('users.create') !!}" class="nav-link"><i class="fa fa-user-plus fa-fw"></i>&nbsp; Sign Up</a></li>
            </ul>

            <ul class="navbar-nav d-none d-md-flex">

                <li class="nav-item"><a href="{{ route('sessions.create') }}" class="nav-link"><i class="fa fa-sign-in"></i>&nbsp; Sign In</a></li>
                <li class="nav-item"><a href="{{ route('users.create') }}" class="nav-link"><i class="fa fa-user-plus"></i>&nbsp; Sign Up</a></li>

            </ul>
        @else
                <li class="nav-item {{ active_class(if_uri_pattern('dashboard', 'active')) }}">
                    <a href="{{ route('users.dashboard') }}" class="nav-link"><i class="fa fa-tachometer"></i>&nbsp; Dashboard</a>
                </li>
                <li class="nav-item dropdown {{ active_class(if_uri_pattern('cycles.*', 'active')) }}">
                    <a class="nav-link dropdown-toggle" id="cycle-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-refresh"></i>&nbsp; Cycles
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cycle-menu">
                        <a class="dropdown-item {{ active_class(if_uri_pattern('cycles/*', 'active')) }}" href="{{ route('cycles.current') }}"><i class="fa fa-refresh"></i>&nbsp; Current Cycle</a>
                        <a class="dropdown-item {{ active_class(if_uri_pattern('cycles', 'active')) }}" href="{{ route('cycles.index') }}"><i class="fa fa-history"></i>&nbsp; All Cycles</a>
                    </div>
                </li>


            </ul>
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="account-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        @if (session('impersonator'))
                          <i class="fa fa-fw fa-user-secret text-danger" data-toggle="tooltip" data-placement="left" title="You are impersonating"></i>
                        @else
                            <i class="fa fa-fw fa-user"></i>
                        @endif
                        {{ ucwords(auth()->user()->getNicknameOrFirstName()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="account-menu">
                        @if (session('impersonator'))
                            {{-- <div class="dropdown-header">Impersonation</div> --}}

                            <!-- Stop Impersonating -->
                            <a class="dropdown-item" href="{{ action('ImpersonationController@stopImpersonating') }}">
                                <i class="fa fa-fw fa-btn fa-user-secret"></i>
                                Back To My Account
                            </a>


                            <div class="divider"></div>
                        @endif
                        <a class="dropdown-item {{ active_class(if_uri_pattern('dashboard', 'active')) }}" href="{{ route('users.dashboard') }}"><i class="fa fa-tachometer"></i>&nbsp; Dashboard</a>
                        <a class="dropdown-item {{ active_class(if_uri_pattern('balance', 'active')) }}" href="{{ route('balance.details') }}"><i class="fa fa-money"></i>&nbsp; Balance ({{ auth()->user()->getBalanceString() }})</a>
                        <a class="dropdown-item {{ active_class(if_uri_pattern('profile', 'active')) }}" href="{{ route('users.profile') }}"><i class="fa fa-user-circle-o"></i>&nbsp; Profile &amp; History</a>

                        <div class="divider"></div>
                        @if (auth()->user()->isAdmin())
                            <div class="dropdown-header">Admin</div>
                            <a class="dropdown-item {{ active_class(if_uri_pattern('admin/dashboard', 'active')) }}" href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer"></i>&nbsp; Admin Dashboard</a>
                            <a class="dropdown-item {{ active_class(if_uri_pattern('users', 'active')) }}" href="{{ route('users.list') }}"><i class="fa fa-users"></i>&nbsp; All Users</a>
                            <a class="dropdown-item {{ active_class(if_uri_pattern('delinquents', 'active')) }}" href="{{ route('users.delinquent') }}"><i class="fa fa-money"></i>&nbsp; Delinquents</a>

                            <div class="divider"></div>
                        @endif
                        @if (auth()->user()->isGod())
                            <div class="dropdown-header">God</div>
                            <a class="dropdown-item {{ active_class(if_uri_pattern('logs', 'active')) }}" href="{{ route('god.logs') }}"><i class="fa fa-tachometer"></i>&nbsp; System Logs</a>

                            <div class="divider"></div>
                        @endif
                        <a class="dropdown-item {{ active_class(if_uri_pattern('signout', 'active')) }}" href="{{ route('sessions.signout') }}"><i class="fa fa-sign-out"></i>&nbsp; Sign out</a>
                    </div>
                </li>
            </ul>
        @endif


        </div><!-- /.navbar-collapse -->

    {{-- </div> --}}<!-- /.container-fluid -->

</nav>