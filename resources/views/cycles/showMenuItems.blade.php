        <li><a href="#details"><i class="fa fa-fw fa-info-circle"></i>&nbsp;Details</a></li>
        <li><a href="#schedule"><i class="fa fa-fw fa-clock-o"></i>&nbsp;Schedule/Results</a></li>
        @if($cycle->areTeamsPublished())
            <!-- <li><a href="#teams"><i class="fa fa-fw fa-users"></i>&nbsp;Teams</a></li> -->
            <!-- <li> -->
            <!-- <ul class="nav navmenu-nav"> -->
            @foreach($cycle->teams as $team)
                <li><a href="{{ '#' . snake_case($team->name) }}">
                @if(strtolower($team->division) === 'mens')
                <i class="fa fa-fw fa-male"></i>&nbsp;Team {{ ucwords($team->name) }}
                @elseif(strtolower($team->division) === 'womens')
                <i class="fa fa-fw fa-female text-info"></i>&nbsp;Team {{ ucwords($team->name) }}
                @else
                <i class="fa fa-male"></i><i class="fa fa-female text-info"></i>&nbsp;Team {{ ucwords($team->name) }}
                @endif
                @if($team->hasPlayer(auth()->user()))
                (yours)
                @endif
                </a></li>
            @endforeach
            <!-- </ul> -->
            <!-- </li> -->
        @else
                <li><a href="#maleSignups"><i class="fa fa-fw fa-male"></i>&nbsp;Sign-ups</a></li>
                <li><a href="#femaleSignups"><i class="fa fa-fw fa-female text-info"></i>&nbsp;Sign-ups</a></li>
        @endif
        <li><a href="#maleSubs"><i class="fa fa-fw fa-male"></i>&nbsp;Subs</a></li>
        <li><a href="#femaleSubs"><i class="fa fa-fw fa-female text-info"></i>&nbsp;Subs</a></li>