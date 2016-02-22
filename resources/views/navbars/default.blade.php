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
                <!-- <li class="visible-xs-block visible-sm-block{{ Active::pattern(['signin'], ' active') }}"><a href="{{ url('signin') }}">Sign in</a></li> -->
                <!-- <li class="visible-xs-block visible-sm-block{{ Active::pattern(['signup'], ' active') }}"><a href="{!! url('users/register') !!}">Sign Up</a></li> -->
            </ul>

            <ul class="nav navbar-nav navbar-right hidden-xs hidden-sm">

                 <!-- <li><a href="{{ url('signin') }}" class="">Sign In</a></li> -->
                <!-- <li><a href="{!! url('users/register') !!}" class="">Sign Up</a></li> -->

            </ul>


        </div><!-- /.navbar-collapse -->

    </div><!-- /.container-fluid -->

</nav>