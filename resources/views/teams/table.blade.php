<div class="table-responsive">
    <table class="table table-condensed table-striped">
{{--     @if(strtolower($team->division) === 'mixed')
        <tr class="default"><th>
        @if(strtolower($players->first()->gender) === 'male')
            Men
        @else
            Women
        @endif
        </th>
        @if(isset($showDivisions) && $showDivisions === true)
            <th class="text-center"></th>
            <th class="text-center"></th>
        @endif
        @foreach($cycle->weeks as $key=>$week)
            <th class="text-center"></th>
        @endforeach
        @if(auth()->user()->isAdmin())
            <th class="text-center"></th>
        @endif
        </tr>
    @endif --}}
        <tr class="text-center">

        @if(strtolower($team->division) === 'mixed')
           @if(strtolower($players->get(0)['user']['gender']) === 'male')
                <th><i class="fa fa-male text-primary"></i>&nbsp;Name</th>
            @else
                <th><i class="fa fa-female text-info"></i>&nbsp;Name</th>
            @endif
        @else
            <th>Name</th>
        @endif
            @if(isset($showDivisions) && $showDivisions === true)
                <th class="text-center">Div1</th>
                <th class="text-center">Div2</th>
            @endif
            @foreach($cycle->weeks as $key=>$week)
                <th class="text-center">Wk{{ $key+1 }}</th>
            @endforeach
            @if(auth()->user()->isAdmin())
                <th class="text-center"><i class="fa fa-star"></i></th>
            @endif
        </tr>
        @foreach( $players as $player )
            @if ($player->user->id === auth()->user()->id)
            <tr class="success">
            @else
            <tr>
            @endif
                @if(auth()->user()->isAdmin())
                    @if ($player->captain)
                    <td><a title="{{ $player->user->name }}" href="{{ route('users.show', $player->user->id) }}">{{ $player->user->getNicknameOrShortName() }}</a>&nbsp;&nbsp;<i class="fa fa-star text-warning"></i></td>
                    @else
                    <td><a title="{{ $player->user->name }}" href="{{ route('users.show', $player->user->id) }}">{{ $player->user->getNicknameOrShortName() }}</a></td>
                    @endif
                @else
                    @if ($player->captain)
                    <td><span title="{{ $player->user->name }}">{{ $player->user->getNicknameOrShortName() }}</span>&nbsp;&nbsp;<i class="fa fa-star fa-fw text-warning"></i></td>
                    @else
                    <td><span title="{{ $player->user->name }}">{{ $player->user->getNicknameOrShortName() }}</span></td>
                    @endif
                @endif
                @if(isset($showDivisions) && $showDivisions === true)
                    <td class="text-center">
                        @if(strtolower($player->user->div_pref_first) === 'mens')
                            <i class="fa fa-male fa-fw text-primary"></i>
                        @elseif(strtolower($player->user->div_pref_first) === 'mixed')
                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                        @elseif(strtolower($player->user->div_pref_first) === 'womens')
                            <i class="fa fa-female fa-fw text-info"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(strtolower($player->user->div_pref_second) === 'mens')
                            <i class="fa fa-male fa-fw text-primary"></i>
                        @elseif(strtolower($player->user->div_pref_second) === 'mixed')
                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                        @elseif(strtolower($player->user->div_pref_second) === 'womens')
                            <i class="fa fa-female fa-fw text-info"></i>
                        @endif
                    </td>
                @endif
                @foreach($player->user->availability()->where('cycle_id',$cycle->id)->orderBy('pivot_week_id')->get() as $week)
                    @if($week->pivot->attending)
                        <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                    @else
                        <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                    @endif
                @endforeach
                @if(auth()->user()->isAdmin())
                    @if ($player->captain)
                        <td class="text-center">
                            <i class="fa fa-thumbs-up fa-fw text-primary"></i>
                        </td>
                    @else
                        <td class="text-center">
                            <i class="fa fa-thumbs-down text-default"></i>
                        </td>
                    @endif
                @endif
            </tr>
        @endforeach
        @if($subs->count() > 0)
            <tr>
                <th colspan=6 class="warning">Subs</th>
            </tr>
        @endif
        @foreach( $subs as $sub )
            @if ($sub->user->id === auth()->user()->id)
            <tr class="success">
            @else
            <tr>
            @endif
                @if(auth()->user()->isAdmin())
                    <td><a title="{{ $sub->user->name }}" href="{{ route('users.show', $sub->user->id) }}">{{ $sub->user->getNicknameOrShortName() }}</a></td>
                @else
                    <td><span title="{{ $sub->user->name }}">{{ $sub->user->getNicknameOrShortName() }}</span></td>
                @endif

                @if(isset($showDivisions) && $showDivisions === true)
                    <td colsspan=2>
                    </td>
                @endif

                @foreach($cycle->weeks as $week )

                    @if($week->id === $sub->week_id)
                        <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                    @else
                        <td class="text-center"><!-- <i class="fa fa-times fa-fw text-danger"></i>--></td>
                    @endif
                @endforeach
                @if(auth()->user()->isAdmin())
                    <td></td>
                @endif
            </tr>
        @endforeach
        <tr class="info">
            @if(isset($showDivisions) && $showDivisions === true)
                <th class="text-center" colspan=3>Total</th>
            @else
                <th class="text-center" colspan=1>Total</th>
            @endif
            <?php
                $weekCount = [];
                foreach($cycle->weeks as $key=>$week) {
                    $playerCount = $players->filter(function ($value, $key) use ($week){
                                return $value->user->isAvailable($week->id);
                            })->count();
                    $subCount = $subs->filter(function ($value, $key) use ($week){
                                return $value->week_id === $week->id;
                            })->count();
                    $weekCount[] = $playerCount + $subCount;
                }
            ?>
            @foreach($weekCount as $count)
                <th class="text-center">{{ $count }}</th>
            @endforeach
            @if(auth()->user()->isAdmin())
                <th class="text-center"></th>
            @endif
        </tr>
    </table>
</div>