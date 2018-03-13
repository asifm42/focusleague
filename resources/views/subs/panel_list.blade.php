<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">{{ ucwords($gender) }} subs</h4>
    </div>
    <div class="card-body p-2">
        @for($i=0, $len=$cycle->weeks()->count(); $i < $len; $i++ )
        <?php
            $subCount = $cycle->weeks[$i]->subs()->$gender()->count() ;
        ?>
        <ul class="list-unstyled">
            @if ($subCount > 0)
                <li class="hidden"><strong>Name</strong><span class="pull-right"><strong>Team</strong></span></li>
            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }} - {{ $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong><span class="badge pull-right">{{ $subCount }}</span></li>
                @foreach($cycle->weeks[$i]->subs()->$gender()->get() as $sub)
                    @if(auth()->user()->isAdmin())
                        <li>
                            <a title="{{ $sub->name }}" href="{{ route('users.show', $sub->id) }}">{{ $sub->getNicknameOrShortName() }}</a>

                            @if (!empty($sub->pivot->note))
                                &nbsp;&nbsp;<i class="fa fa-sticky-note text-warning"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-container="body"
                                        data-trigger="focus click hover"
                                        data-html="true"
                                        data-title="{{ $sub->pivot->note }}"></i>
                            @endif
                            @if ($sub->pivot->team_id)
                                <span class="pull-right"><a href="{{ route('subs.teamPlacementForm', $sub->pivot->id) }}">{{ ucwords($cycle->teams->find($sub->pivot->team_id)->nameAndDivision()) }}</a></span>
                            @else
                                <span class="pull-right"><em><a href="{{ route('subs.teamPlacementForm', $sub->pivot->id) }}">Select</a></em></span>
                            @endif
                        </li>
                    @else
                        <li>
                            <span title="{{ $sub->name }}"=>{{$sub->getNicknameOrShortName()}}</span>

                            @if (!empty($sub->pivot->note) && ($sub->id === auth()->user()->id) )
                                &nbsp;&nbsp;<i class="fa fa-sticky-note text-warning"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        data-container="body"
                                        data-trigger="focus click hover"
                                        data-html="true"
                                        data-title="{{ $sub->pivot->note }}"></i>
                            @endif
                            @if ($sub->pivot->team_id)
                                <span class="pull-right">{{ ucwords($cycle->teams->find($sub->pivot->team_id)->name) }}</span>
                            @else
                                <span class="pull-right"><em>Team TBD</em></span>
                            @endif
                        </li>
                    @endif
                @endforeach
                @else

            <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }} - {{ $cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong><span class="badge pull-right">{{ $subCount = $cycle->weeks[$i]->subs()->$gender()->count() }}</span></li>
            @endif
        </ul>
        @endfor
    </div>
</div>