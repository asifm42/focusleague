<nav class="navbar navbar-default">

    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('site.home') }}">FOCUS League</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <li class={{ Active::pattern(['/'], 'active') }}><a href="{{ route('site.home') }}">Home</a></li>
                <li class={{ Active::pattern(['news'], 'active') }}><a href="{{ route('site.news') }}">News</a></li>
                <li class={{ Active::pattern(['faq'], 'active') }}><a href="{{ route('site.faq') }}">FAQ</a></li>
        @if(! auth()->check())
                <li class="visible-xs-block visible-sm-block{{ Active::pattern(['signin'], ' active') }}"><a href="{{ route('sessions.create') }}">Sign in</a></li>
                <li class="visible-xs-block visible-sm-block{{ Active::pattern(['signup'], ' active') }}"><a href="{!! route('users.create') !!}">Sign Up</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right hidden-xs hidden-sm">

                <li><a href="{{ route('sessions.create') }}" class="">Sign In</a></li>
                <li><a href="{!! route('users.create') !!}" class="">Sign Up</a></li>

            </ul>
        @else
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a id="account-menu" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp; {{ auth()->user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="account-menu">
                        <li class="{{ Active::pattern('profile', 'active') }}"><a href="{{ route('users.profile') }}"><i class="fa fa-cog"></i>&nbsp; Profile</a></li>
                        <li class="{{ Active::pattern('signout', 'active') }}"><a href="{{ route('sessions.signout') }}"><i class="fa fa-cog"></i>&nbsp; Sign out</a></li>
                    </ul>
                </li>
            </ul>
        @endif


        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->

</nav>