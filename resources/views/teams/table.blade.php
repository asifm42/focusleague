<div class="table-responsive">
    <table class="table table-sm table-striped mb-0">
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
           @if(strtolower($players->first()['user']['gender']) == 'male')
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
            <tr class="table-primary">
            @else
            <tr>
            @endif
                @if(auth()->user()->isAdmin())
                    <td>
                        <a title="{{ $player->user->name }}" href="{{ route('users.show', $player->user->id) }}">{{ $player->user->getNicknameOrShortName() }}</a>
                        @if ($player->captain)
                            &nbsp;&nbsp;<i class="fa fa-star text-warning"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    data-container="body"
                                    data-trigger="focus click hover"
                                    data-html="true"
                                    data-title="Team Captain"></i>
                        @endif
                        @if (!empty($player->note))
                            &nbsp;&nbsp;<i class="fa fa-sticky-note text-warning"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    data-container="body"
                                    data-trigger="focus click hover"
                                    data-html="true"
                                    data-title="{{ $player->note }}"></i>
                        @endif
                    </td>
                @else
                    <td>
                        <span title="{{ $player->user->name }}">{{ $player->user->getNicknameOrShortName() }}</span>
                        @if ($player->captain)
                            &nbsp;&nbsp;<i class="fa fa-star fa-fw text-warning"></i>
                        @endif
                        @if (!empty($player->note) && ($player->user->id === auth()->user()->id) )
                            &nbsp;&nbsp;<i class="fa fa-sticky-note text-warning"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    data-container="body"
                                    data-trigger="focus click hover"
                                    data-html="true"
                                    data-title="{{ $player->note }}"></i>
                        @endif
                    </td>
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
                <th colspan=6 class="table-warning text-center">
                @if(strtolower($team->division) === 'mixed')
                   @if(strtolower($subs->first()['user']['gender']) === 'male')
                        <i class="fa fa-male text-primary"></i>&nbsp;Subs
                    @else
                        <i class="fa fa-female text-info"></i>&nbsp;Subs
                    @endif
                @else
                    Subs
                @endif
                </th>
            </tr>
            @foreach( $subs as $sub )
                @if ($sub->user->id === auth()->user()->id)
                <tr class="success">
                @else
                <tr>
                @endif
                    @if(auth()->user()->isAdmin())
                        <td>
                            <a title="{{ $sub->user->name }}" href="{{ route('users.show', $sub->user->id) }}">{{ $sub->user->getNicknameOrShortName() }}</a>

                        @if (!empty($sub->note))
                            &nbsp;&nbsp;<i class="fa fa-sticky-note text-warning"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    data-container="body"
                                    data-trigger="focus click hover"
                                    data-html="true"
                                    data-title="{{ $sub->note }}"></i>
                        @endif
                        </td>
                    @else
                        <td>
                            <span title="{{ $sub->user->name }}">{{ $sub->user->getNicknameOrShortName() }}</span>
                            @if (!empty($sub->note) && ($sub->user->id === auth()->user()->id) )
                                &nbsp;&nbsp;<i class="fa fa-sticky-note text-warning"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-container="body"
                                        data-trigger="focus click hover"
                                        data-html="true"
                                        data-title="{{ $sub->note }}"></i>
                            @endif
                        </td>
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
        @endif
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