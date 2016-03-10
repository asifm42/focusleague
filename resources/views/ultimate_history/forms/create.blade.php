<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Provide your Ultimate History</h3>
    </div>

    <div class="panel-body">
        @if($edit === true)
            {!! Former::vertical_open()
                ->method('PATCH')
                ->action(route('users.ultimate_history.update', $user->id))
            !!}
        @else
            {!! Former::vertical_open()
                ->action(route('users.ultimate_history.store', $user->id))
            !!}
        @endif

        {!! Former::text('club_affiliation')
            ->addClass('form-control')
            ->placeholder('Required club affiliation')
            ->autofocus('autofocus')
            ->required()
            ->label("Who are you playing with in the USA Ultimate series")
        !!}
        {!! Former::select('years_played')
            ->addClass('form-control')
            ->options([
                '0-1'   => "0-1 years",
                '2-3'   => "2-3 years",
                '4-6'   => "4-6 years",
                '7-10'  => "7-10 years",
                '11-15' => "11-15 years",
                '16+'   => "16+ years",
                ])
            ->placeholder('Required years played')
            ->required()
        !!}
        {!! Former::textarea('summary')
            ->addClass('form-control')
            ->placeholder('Required summay')
            ->required()
            ->help('Give us a brief summary of your Ultimate History. i.e List teams you have played for and when. List any prominent tournies you have competed in and when.')
        !!}
        {!! Former::select('def_or_off')
            ->label('Do you consider yourself a defensive or an offensive player')
            ->options([ 'Defensive' => 'Defensive', 'Offensive' => 'Offensive'])
            ->addClass('form-control')
            ->placeholder('Required defensive or offensive')
            ->required()
        !!}

        {!! Former::text('fav_offensive_position')
            ->label('What is your favorite offensive position?')
            ->addClass('form-control')
            ->placeholder('Required favorite offensive position')
            ->required()
        !!}
        {!! Former::text('fav_defensive_position')
            ->label('What is your favorite defensive position?')
            ->addClass('form-control')
            ->placeholder('Required favorite defensive position')
            ->required()
        !!}
        {!! Former::text('best_skill')
            ->label('What do you consider your best skill in Ultimate?')
            ->addClass('form-control')
            ->placeholder('Required best ultimate skill')
            ->required()
        !!}
        {!! Former::text('skill_to_improve')
            ->label('What do you consider the skill you need to most improve on in Ultimate?')
            ->addClass('form-control')
            ->placeholder('Required skill you want to improve')
            ->required()
        !!}
        {!! Former::text('best_throw')
            ->label('What do you consider your best throw in Ultimate?')
            ->addClass('form-control')
            ->placeholder('Required best ultimate throw')
            ->required()
        !!}
        {!! Former::text('throw_to_improve')
            ->label('What do you consider the throw you need to most improve on in Ultimate?')
            ->addClass('form-control')
            ->placeholder('Required throw you want to improve')
            ->required()
        !!}
    </div>

    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Save')
        !!}
    </div>
    {!! Former::close() !!}
</div>

@section('scripts')
    <script>
        $(document).ready( function () {

        })
    </script>
@stop