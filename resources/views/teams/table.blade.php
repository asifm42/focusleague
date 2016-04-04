<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <tr class="text-center">
            <th>Name</th>
            @if(isset($showDivisions) && $showDivisions === true)
                <th class="text-center">Div1</th>
                <th class="text-center">Div2</th>
            @endif
                <th class="text-center">Wk1</th>
                <th class="text-center">Wk2</th>
                <th class="text-center">Wk3</th>
                <th class="text-center">Wk4</th>
            @if(auth()->user()->isAdmin())
                <th class="text-center"><i class="fa fa-star"></i></th>
            @endif
        </tr>
        @foreach( $players as $player )
            <tr>
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
        <tr class="info">
            @if(isset($showDivisions) && $showDivisions === true)
                <th class="text-center" colspan=3>Total</th>
            @else
                <th class="text-center" colspan=1>Total</th>
            @endif
            <?php
                $week1Count = $players->filter(function ($value, $key) use ($cycle){
                            return $value->user->isAvailable($cycle->weeks[0]->id);
                        })->count();
                $week2Count = $players->filter(function ($value, $key) use ($cycle){
                            return $value->user->isAvailable($cycle->weeks[1]->id);
                        })->count();
                $week3Count = $players->filter(function ($value, $key) use ($cycle){
                            return $value->user->isAvailable($cycle->weeks[2]->id);
                        })->count();
                $week4Count = $players->filter(function ($value, $key) use ($cycle){
                            return $value->user->isAvailable($cycle->weeks[3]->id);
                        })->count();
            ?>
            <th class="text-center">{{ $week1Count }}</th>
            <th class="text-center">{{ $week2Count }}</th>
            <th class="text-center">{{ $week3Count }}</th>
            <th class="text-center">{{ $week4Count }}</th>
            @if(auth()->user()->isAdmin())
                <th class="text-center"></th>
            @endif
        </tr>
    </table>
</div>