<div class="panel panel-default">
<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('subs.updateTeamPlacement', $sub->id) }}"
    @else
        action="{{ route('subs.placeOnATeam', $sub->id) }}"
    @endif
    >

    <div class="panel-heading">
        <h3 class="panel-title">Place sub on a team</h3>
    </div>
<?php
    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

    $team_options = [];
    foreach($cycle_teams as $team) {
        $team_options[$team->id] = $team->name;
    }
?>
    <div class="panel-body">
        <h4>Cycle {{ $cycle->name }} - Week {{ $sub->week->index() }}</h4>

        {!! Former::text('nickname')
            ->label('Player')
            ->addClass('form-control')
            ->placeholder($user->getNicknameOrShortname())
            ->disabled()
        !!}
        {!! Former::select('team_id')
            ->label('team')
            ->options($team_options, $sub->team_id)
            ->addClass('form-control')
            ->placeholder('Required team')
            ->required()
        !!}
    </div>

    <div class="panel-footer">
        @if($edit === true)
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
            {!! Former::close() !!}

        @else
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
            {!! Former::close() !!}
            @if ($sub->team_id)

            <a href="{{route( 'subs.deleteTeamPlacement', $sub->id)}}" class='pull-right btn btn-danger'>Remove from team</a>
            @endif
        @endif
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready( function () {
            // For popovers on the navbar
            // $('[data-toggle="popover"]').popover();

        })
    </script>
@endpush