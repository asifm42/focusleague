<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ auth()->check() ? url('dashboard') : url() }}">
                @include('svg.inside-navbar-black-woTag')
            </a>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
        @if (auth()->check())
            <ul class="nav navbar-nav">
                <li class="{{ Active::pattern('projects', 'active') }}"><a href="{{ url('projects') }}"><i class="fa fa-newspaper-o"></i>&nbsp; Projects</a></li>
                <li class="{{ Active::pattern('resources','active') }}"><a href="{{ url('resources') }}"><i class="fa fa-archive"></i>&nbsp; Resources</a></li>
                <li class="{{ Active::pattern('settings', 'active') }} hidden"><a href="{{ url('settings') }}"><i class="fa fa-cog"></i>&nbsp; Settings</a></li>
                <li><a target="_blank" href="{{ url('help') }}"><i class="fa fa-support"></i>&nbsp; Help</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @include('users.subscriptionAlerts')
                <li class="dropdown">
                    <a id="account-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp; {{ auth()->user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="account-menu">
                        <li class="{{ Active::pattern('settings', 'active') }}"><a href="{{ url('settings') }}"><i class="fa fa-cog"></i>&nbsp; Settings</a></li>

                    @if (auth()->user()->onFreeTrial())
                        @if (auth()->user()->daysLeftInTrial() == 1)
                            <li class="{{ Active::pattern('subscribe', 'active') }}"><a href="{{ url('subscribe') }}"><i class="fa fa-feed"></i>&nbsp; Subscribe - 1 day left</a></li>
                        @else
                            <li class="{{ Active::pattern('subscribe', 'active') }}"><a href="{{ url('subscribe') }}"><i class="fa fa-feed"></i>&nbsp; Subscribe - {{{ auth()->user()->daysLeftInTrial() }}} days left</a></li>
                        @endif
                    @elseif (auth()->user()->isExpired())
                        <li class="{{ Active::pattern('subscribe', 'active') }}"><a href="{{ url('subscribe') }}"><i class="fa fa-feed"></i>&nbsp; Subscribe</a></li>
                    @endif

                    @if (! auth()->user()->onFreeLifetime())
                        <li class="{{ Active::pattern('billings', 'active') }}"><a href="{{ url('billings') }}"><i class="fa fa-credit-card"></i>&nbsp; Billing</a></li>
                    @endif

                        <li role="separator" class="divider"></li>
                        <li><a href="{{ url('signout') }}"><i class="fa fa-sign-out"></i>&nbsp; Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        @else
            @if (! app()->isDownForMaintenance())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('signin') }}"><i class="fa fa-sign-in"></i>&nbsp; Sign In</a></li>
                    <li><a href="{{ url('signup') }}"><i class="fa fa-user"></i>&nbsp; Sign Up</a></li>
                </ul>
            @endif
        @endif
        </div>
    </div>
</nav>