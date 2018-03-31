<div class="table-responsive">
<table class="table table-sm table-striped mb-0">
<tr>
    <th class="text-center">Div1</th>
    <th class="text-center">Div2</th>
    @foreach($cycle->weeks as $key=>$week)
        <th class="text-center">Wk{{ $key+1 }}</th>
    @endforeach
    <th class="text-center">Will capt?</th>
</tr>
<tr>

<td class="text-center">
    @if(strtolower($cycle_signup->pivot->div_pref_first) === 'mens')
        <i class="fa fa-male fa-fw text-primary"></i>
    @elseif(strtolower($cycle_signup->pivot->div_pref_first) === 'mixed')
        <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
    @elseif(strtolower($cycle_signup->pivot->div_pref_first) === 'womens')
        <i class="fa fa-female fa-fw text-info"></i>
    @endif
</td>
<td class="text-center">
    @if(strtolower($cycle_signup->pivot->div_pref_second) === 'mens')
        <i class="fa fa-male fa-fw text-primary"></i>
    @elseif(strtolower($cycle_signup->pivot->div_pref_second) === 'mixed')
        <i class="fa fa-male text-primary"></i><i class="fa fa-female text-info"></i>
    @elseif(strtolower($cycle_signup->pivot->div_pref_second) === 'womens')
        <i class="fa fa-female fa-fw text-info"></i>
    @endif
</td>

    @foreach($user->availability()->where('cycle_id', $cycle->id)->get() as $week)
        @if($week->pivot->attending)
            <td class="text-center"><i class="fa fa-check fa-fw text-success"></i></td>
        @else
            <td class="text-center"><i class="fa fa-times fa-fw text-danger"></i></td>
        @endif
    @endforeach
    <td class="text-center">
        @if ($cycle_signup->pivot->will_captain)
        <i class="fa fa-check fa-fw text-success"></i>
        @else
        <i class="fa fa-times fa-fw text-danger"></i>
        @endif
    </td>
</tr>
@if (!empty($cycle_signup->pivot->note))
    <tr>
        <td colspan="6">
            <i class="fa fa-sticky-note text-warning"></i>&nbsp;&nbsp;{{ $cycle_signup->pivot->note }}
        </td>
    </tr>
@endif
</table>
</div>