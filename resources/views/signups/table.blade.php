<div class="table-responsive">
    <table class="table table-condensed table-striped">
        <tr class="text-center">
            <th>Name</th>
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
        @foreach( $signups as $signup )
            @if ($signup->id === auth()->user()->id)
            <tr class="success">
            @else
            <tr>
            @endif
                @if(auth()->user()->isAdmin())
                    <td><a title="{{ $signup->name }}" href="{{ route('users.show', $signup->id) }}">{{ $signup->getNicknameOrShortName() }}</a></td>
                @else
                    <td><span title="{{ $signup->name }}">{{ $signup->getNicknameOrShortName() }}</span></td>
                @endif
                @if(isset($showDivisions) && $showDivisions === true)
                    <td class="text-center">
                        @if(strtolower($signup->pivot->div_pref_first) === 'mens')
                            <i class="fa fa-male fa-fw text-primary"></i>
                        @elseif(strtolower($signup->pivot->div_pref_first) === 'mixed')
                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                        @elseif(strtolower($signup->pivot->div_pref_first) === 'womens')
                            <i class="fa fa-female fa-fw text-info"></i>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(strtolower($signup->pivot->div_pref_second) === 'mens')
                            <i class="fa fa-male fa-fw text-primary"></i>
                        @elseif(strtolower($signup->pivot->div_pref_second) === 'mixed')
                            <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
                        @elseif(strtolower($signup->pivot->div_pref_second) === 'womens')
                            <i class="fa fa-female fa-fw text-info"></i>
                        @endif
                    </td>
                @endif
                @foreach($signup->availability()->where('cycle_id',$cycle->id)->orderBy('pivot_week_id')->get() as $week)
                    @if($week->pivot->attending)
                        <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
                    @else
                        <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
                    @endif
                @endforeach
                @if(auth()->user()->isAdmin())
                    @if ($signup->pivot->will_captain)
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
                $weekCount = [];
                foreach($cycle->weeks as $key=>$week) {
                    $weekCount[] = $signups->filter(function ($value, $key) use ($week){
                                return $value->isAvailable($week->id);
                            })->count();
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