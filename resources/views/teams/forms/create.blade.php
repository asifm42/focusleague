<div class="panel panel-default">
<form accept-charset="utf-8" class="form-vertical" method="POST"
    @if ($edit === true)
        action="{{ route('teams.update', $team->id) }}"
    @else
        action="{{ route('teams.store') }}"
        @php
            $team = new \App\Models\Team;
        @endphp
    @endif
    >

    <div class="panel-heading">
        <h3 class="panel-title">Create team for Cycle {{ $cycle->name }}</h3>
    </div>
    @if ($edit === true)
        {!! method_field('patch') !!}
    @endif

    <div class="panel-body">

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

@push('scripts')
    <script>
        $(document).ready( function () {
            // For popovers on the navbar
            // $('[data-toggle="popover"]').popover();

        })
    </script>
@endpush