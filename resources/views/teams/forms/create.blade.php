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
        @if($edit === true)
            {!! Form::delete(route( 'teams.destroy', $team->id), '', ['class' => 'pull-right'],['class' => 'btn btn-danger'] ) !!}
        @endif
        {!! Former::close() !!}
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