<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Create team for Cycle {{ $cycle->name }}</h3>
    </div>

    <div class="panel-body">
        @if($edit === true)
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('teams.update', $team->id))
            !!}
        @else
            {!! Former::vertical_open()
                ->action(route('teams.store'))
            !!}
        @endif

        {!! Former::text('name')
            ->label('Team Name')
            ->addClass('form-control')
            ->placeholder('Required team name')
            ->required()
        !!}
        {!! Former::select('division')
            ->options(['mens' => 'Mens', 'mixed' => 'Mixed', 'womens' => 'Womens'])
            ->addClass('form-control')
            ->placeholder('Required division')
            ->required()
        !!}
        {!! Former::hidden('cycle_id')->value($cycle->id) !!}
    </div>
    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Save')
        !!}
        {!! Former::close() !!}
        @if($edit === true)

            {!! Former::open()
                ->method('DELETE')
                ->class('pull-right')
                ->action(route('teams.destroy', $team->id))
            !!}
            {!! Former::submit()
                ->addClass('btn btn-danger')
                ->value('Delete')
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