<nav class="navbar navbar-default">

    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
<!--                 <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> -->
                <span style="font-size:1em"><strong>NAV</strong></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('site.home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="FOCUS League" title="FOCUS League" class="logo-navbar"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <li class={{ Active::pattern(['/'], 'active') }}><a href="{{ route('site.home') }}"><i class="fa fa-fw fa-home"></i>&nbsp; Home</a></li>
                <li class={{ Active::pattern(['news'], 'active') }}><a href="{{ route('site.news') }}"><i class="fa fa-fw fa-newspaper-o"></i>&nbsp; News</a></li>
                <li class={{ Active::pattern(['faq'], 'active') }}><a href="{{ route('site.faq') }}"><i class="fa fa-fw fa-question"></i>&nbsp; FAQ</a></li>
                <li class={{ Active::pattern(['contact'], 'active') }}><a href="{{ route('contact.create') }}"><i class="fa fa-fw fa-envelope"></i>&nbsp; Contact</a></li>
        @if(! auth()->check())
                <li class="visible-xs-block visible-sm-block{{ Active::pattern(['signin'], ' active') }}"><a href="{{ route('sessions.create') }}"><i class="fa fa-sign-in fa-fw"></i>&nbsp; Sign In</a></li>
                <li class="visible-xs-block visible-sm-block{{ Active::pattern(['signup'], ' active') }}"><a href="{!! route('users.create') !!}"><i class="fa fa-user-plus fa-fw"></i>&nbsp; Sign Up</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right hidden-xs hidden-sm">

                <li><a href="{{ route('sessions.create') }}" class=""><i class="fa fa-sign-in"></i>&nbsp; Sign In</a></li>
                <li><a href="{!! route('users.create') !!}" class=""><i class="fa fa-user-plus"></i>&nbsp; Sign Up</a></li>

            </ul>
        @else
                <li class="{{ Active::pattern('dashboard', 'active') }}"><a href="{{ route('users.dashboard') }}"><i class="fa fa-tachometer"></i>&nbsp; Dashboard</a></li>
                {{--<li class="{{ Active::pattern('cycles/*', 'active') }}"><a href="{{ route('cycles.current') }}"><i class="fa fa-refresh"></i>&nbsp; Cycle</a></li>--}}
                <li class="dropdown {{ Active::routePattern('cycles.*', 'active') }}">
                    <a id="cycle-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-refresh"></i>&nbsp; Cycles&nbsp;<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="cycle-menu">
                        <li class="{{ Active::pattern('cycles/*', 'active') }}"><a href="{{ route('cycles.current') }}"><i class="fa fa-refresh"></i>&nbsp; Current Cycle</a></li>
                        <li class="{{ Active::pattern('cycles', 'active') }}"><a href="{{ route('cycles.index') }}"><i class="fa fa-history"></i>&nbsp; All Cycles</a></li>
                    </ul>
                </li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a id="account-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp; {{ ucwords(auth()->user()->getNicknameOrFirstName()) }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="account-menu">
                        <li class="{{ Active::pattern('dashboard', 'active') }}"><a href="{{ route('users.dashboard') }}"><i class="fa fa-tachometer"></i>&nbsp; Dashboard</a></li>
                        <li class="{{ Active::pattern('balance', 'active') }}"><a href="{{ route('balance.details', auth()->user()->id) }}"><i class="fa fa-money"></i>&nbsp; Balance ({{ auth()->user()->getBalanceString() }})</a></li>
                        @if (auth()->user()->isAdmin())
                            <li class="{{ Active::pattern('admin/dashboard', 'active') }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer"></i>&nbsp; Admin Dashboard</a></li>
                            <li class="{{ Active::pattern('users', 'active') }}"><a href="{{ route('users.list') }}"><i class="fa fa-users"></i>&nbsp; All Users</a></li>
                            <li class="{{ Active::pattern('delinquents', 'active') }}"><a href="{{ route('users.delinquent') }}"><i class="fa fa-money"></i>&nbsp; Delinquents</a></li>
                        @endif
                        <li class="{{ Active::pattern('signout', 'active') }}"><a href="{{ route('sessions.signout') }}"><i class="fa fa-sign-out"></i>&nbsp; Sign out</a></li>
                    </ul>
                </li>
            </ul>
        @endif


        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->

</nav>