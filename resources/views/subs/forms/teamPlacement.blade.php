<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Place sub on a team</h3>
    </div>
<?php
    $team_options = [];
    foreach($cycle_teams as $team) {
        $team_options[$team->id] = $team->name;
    }
?>
    <div class="panel-body">
        @if($edit === true)
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('subs.updateTeamPlacement', $sub->id))
            !!}
        @else
            {!! Former::vertical_open()
                ->action(route('subs.placeOnATeam', $sub->id))
            !!}
        @endif

        <h4>Cycle {{ $cycle->name }} - Week {{ $sub->week->week_index() }}</h4>

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

            {{-- {!! Form::delete(route( 'sub.destroy', $sub->id), '', ['class' => 'pull-right'],['class' => 'btn btn-danger'] ) !!} --}}
        @else
            {!! Former::submit()
                ->addClass('btn btn-primary')
                ->value('Save')
            !!}
            {!! Former::close() !!}
        @endif
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready( function () {
            // For popovers on the navbar
            // $('[data-toggle="popover"]').popover();

        })
    </script>
@stop