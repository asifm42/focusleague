<!-- <nav class="navbar navbar-default"> --><nav class="nav footer">

    <div class="container-fluid">
    <div class="row">
    <div class="col-xs-12 col-sm-8">
    <div class="row">
        <div class="col-xs-4 col-sm-3">
            <ul class="nav nav-pills nav-stacked">
                <div class="hidden">
                <li class={{ Active::pattern(['/'], 'active') }}><a href="{{ route('site.home') }}"><i class="fa fa-fw fa-home hidden-xs"></i>Home</a></li>
                <li class={{ Active::pattern(['news'], 'active') }}><a href="{{ route('site.news') }}"><i class="fa fa-fw fa-newspaper-o hidden-xs"></i>News</a></li>
                <li class={{ Active::pattern(['faq'], 'active') }}><a href="{{ route('site.faq') }}"><i class="fa fa-fw fa-question hidden-xs"></i>FAQ</a></li>
                <li class={{ Active::pattern(['contact'], 'active') }}><a href="{{ route('contact.create') }}"><i class="fa fa-fw fa-envelope hidden-xs"></i>Contact</a></li>
                </div>
                <li><a href="{{ route('site.home') }}"><i class="fa fa-fw fa-home hidden-xs"></i> Home</a></li>
                <li><a href="{{ route('site.news') }}"><i class="fa fa-fw fa-newspaper-o hidden-xs"></i> News</a></li>
                <li><a href="{{ route('site.faq') }}"><i class="fa fa-fw fa-question hidden-xs"></i> FAQ</a></li>
                <li><a href="{{ route('contact.create') }}"><i class="fa fa-fw fa-envelope hidden-xs"></i> Contact</a></li>
            </ul>
        </div>
        @if(! auth()->check())
        <div class="col-xs-4 col-sm-3">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="{{ route('sessions.create') }}"><i class="fa fa-fw fa-sign-in hidden-xs"></i> Sign In</a></li>
                <li><a href="{{ route('users.create') }}"><i class="fa fa-fw fa-user-plus hidden-xs"></i> Sign Up</a></li>
            </ul>
        </div>
        @else
        <div class="col-xs-4 col-sm-3">
            <ul class="nav nav-pills nav-stacked">
                <div class="hidden">
                <li class="{{ Active::pattern('dashboard', 'active') }}"><a href="{{ route('users.dashboard') }}"><i class="fa fa-fw fa-tachometer hidden-xs"></i>Dashboard</a></li>
                <li class="{{ Active::pattern('cycles/*', 'active') }}"><a href="{{ route('cycles.current') }}"><i class="fa fa-fw fa-refresh hidden-xs"></i>Current Cycle</a></li>
                <li class="{{ Active::pattern('cycles', 'active') }}"><a href="{{ route('cycles.index') }}"><i class="fa fa-fw fa-history hidden-xs"></i>All Cycles</a></li>
                </div>
                <li><a href="{{ route('users.dashboard') }}"><i class="fa fa-fw fa-tachometer hidden-xs"></i> Dashboard</a></li>
                <li><a href="{{ route('cycles.current') }}"><i class="fa fa-fw fa-refresh hidden-xs"></i> Current Cycle</a></li>
                <li><a href="{{ route('cycles.index') }}"><i class="fa fa-fw fa-history hidden-xs"></i> All Cycles</a></li>
            </ul>
        </div>

        <div class="col-xs-4 col-sm-4">
            <ul class="nav nav-pills nav-stacked">
                <div class="hidden">
                <li class="{{ Active::pattern('balance', 'active') }}"><a href="{{ route('balance.details') }}"><i class="fa fa-fw fa-money hidden-xs"></i>Balance ({{ auth()->user()->getBalanceString() }})</a></li>
                @if (auth()->user()->isAdmin())
                    <li class="{{ Active::pattern('admin/dashboard', 'active') }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-tachometer hidden-xs"></i>Admin Dashboard</a></li>
                    <li class="{{ Active::pattern('users', 'active') }}"><a href="{{ route('users.list') }}"><i class="fa fa-fw fa-users hidden-xs"></i>All Users</a></li>
                    <li class="{{ Active::pattern('delinquents', 'active') }}"><a href="{{ route('users.delinquent') }}"><i class="fa fa-fw fa-money hidden-xs"></i>Delinquents</a></li>
                @endif
                <li class="{{ Active::pattern('signout', 'active') }}"><a href="{{ route('sessions.signout') }}"><i class="fa fa-fw fa-sign-out hidden-xs"></i>Sign out</a></li>
                </div>
                <li><a href="{{ route('balance.details') }}"><i class="fa fa-fw fa-money hidden-xs"></i> Balance ({{ auth()->user()->getBalanceString() }})</a></li>
                @if (auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-tachometer hidden-xs"></i> Admin Dashboard</a></li>
                    <li><a href="{{ route('users.list') }}"><i class="fa fa-fw fa-users hidden-xs"></i> All Users</a></li>
                    <li><a href="{{ route('users.delinquent') }}"><i class="fa fa-fw fa-money hidden-xs"></i> Delinquents</a></li>
                @endif
                <li><a href="{{ route('sessions.signout') }}"><i class="fa fa-fw fa-sign-out hidden-xs"></i> Sign out</a></li>
            </ul>
        </div>
        @endif

        </div> <!-- row -->
        </div><!-- col-xs-12 col-sm-8 -->
        </div> <!-- row -->
    </div><!-- /.container-fluid -->

</nav>