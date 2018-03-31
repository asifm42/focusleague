<nav class="nav footer">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 col-sm-4 col-md-3">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a  class="nav-link px-1" href="{{ route('site.home') }}"><i class="fa fa-fw fa-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link px-1" href="{{ route('site.news') }}"><i class="fa fa-fw fa-newspaper-o"></i> News</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link px-1" href="{{ route('site.faq') }}"><i class="fa fa-fw fa-question "></i> FAQ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link px-1" href="{{ route('contact.create') }}"><i class="fa fa-fw fa-envelope "></i> Contact</a>
                  </li>
                </ul>
            </div>
            @if(! auth()->check())
            <div class="col-6 col-sm-4 col-md-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('sessions.create') }}"><i class="fa fa-fw fa-sign-in "></i> Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('users.create') }}"><i class="fa fa-fw fa-user-plus "></i> Sign Up</a>
                    </li>
                </ul>
            </div>
            @else
            <div class="col-6 col-sm-4 col-md-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('users.dashboard') }}"><i class="fa fa-fw fa-tachometer"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('cycles.current') }}"><i class="fa fa-fw fa-refresh"></i> Current Cycle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('cycles.index') }}"><i class="fa fa-fw fa-history"></i> All Cycles</a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-sm-4 col-md-3">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('balance.details') }}"><i class="fa fa-fw fa-money"></i> Balance ({{ auth()->user()->getBalanceString() }})</a>
                    </li>
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link px-1" href="{{ route('admin.dashboard') }}"><i class="fa fa-fw fa-tachometer hidden-xs"></i> Admin Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-1" href="{{ route('users.list') }}"><i class="fa fa-fw fa-users hidden-xs"></i> All Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-1" href="{{ route('users.delinquent') }}"><i class="fa fa-fw fa-money hidden-xs"></i> Delinquents</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link px-1" href="{{ route('sessions.signout') }}"><i class="fa fa-fw fa-sign-out hidden-xs"></i> Sign out</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>

</nav>