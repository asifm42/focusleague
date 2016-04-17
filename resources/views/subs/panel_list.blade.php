<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">{{ ucwords($gender) }} subs</h4>
    </div>
    <div class="panel-body">
        @for($i=0, $len=$cycle->weeks()->count(); $i < $len; $i++ )
        <ul class="list-unstyled">
            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }} - {{ $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong><span class="badge pull-right">{{ $cycle->weeks[$i]->subs()->$gender()->count() }}</span></li>
            @foreach($cycle->weeks[$i]->subs()->$gender()->get() as $sub)
                @if(auth()->user()->isAdmin())
                    <li>
                        <a title="{{ $sub->name }}" href="{{ route('users.show', $sub->id) }}">{{ $sub->getNicknameOrShortName() }}</a>
                        @if ($sub->pivot->team_id)
                            <span class="pull-right"><a href="{{ route('subs.teamPlacementForm', $sub->pivot->id) }}">Team {{ ucwords($cycle->teams->find($sub->pivot->team_id)->name) }}</a></span>
                        @else
                            <span class="pull-right"><em><a href="{{ route('subs.teamPlacementForm', $sub->pivot->id) }}">Place sub</a></em></span>
                        @endif
                    </li>
                @else
                    <li>
                        <span title="{{ $sub->name }}"=>{{$sub->getNicknameOrShortName()}}</span>
                        @if ($sub->pivot->team_id)
                            <span class="pull-right">Team {{ ucwords($cycle->teams->find($sub->pivot->team_id)->name) }}</span>
                        @else
                            <span class="pull-right"><em>Team TBD</em></span>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
        @endfor
    </div>
</div>