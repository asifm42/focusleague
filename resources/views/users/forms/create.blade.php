<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">Sign up for a new account</h3>
    </div>

    <div class="panel-body">
        {!! Former::vertical_open()
            ->action(route('users.store'))
        !!}

        {!! Former::text('name')
            ->addClass('form-control')
            ->placeholder('Required name')
            ->autofocus('autofocus')
            ->required()
        !!}
        {!! Former::text('nickname')
            ->addClass('form-control')
            ->placeholder('Optional nickname')
        !!}
        {!! Former::text('email')
            ->addClass('form-control')
            ->placeholder('Required email')
            ->required()
        !!}
        {!! Former::text('cell_number')
            ->addClass('form-control')
            ->placeholder('Required cell number')
            ->help('for last-minute text communications')
            ->required()
        !!}
        {!! Former::select('gender')
            ->addClass('form-control')
            ->options(['male' => 'Male', 'female' => 'Female'])
            ->placeholder('Required gender')
            ->required()
        !!}
        {!! Former::date('birthday')
            ->addClass('form-control')
            ->placeholder('Required birthday')
            ->required()
        !!}
        {!! Former::select('dominant_hand')
            ->addClass('form-control')
            ->options(['left' => 'Left', 'right' => 'Right'])
            ->placeholder('Required dominant hand')
            ->required()
        !!}
        {!! Former::select('height')
            ->addClass('form-control')
            ->options([
                '56' => "4' 8\"",
                '57' => "4' 9\"",
                '58' => "4' 10\"",
                '59' => "4' 11\"",
                '60' => "5' 0\"",
                '61' => "5' 1\"",
                '62' => "5' 2\"",
                '63' => "5' 3\"",
                '64' => "5' 4\"",
                '65' => "5' 5\"",
                '66' => "5' 6\"",
                '67' => "5' 7\"",
                '68' => "5' 8\"",
                '69' => "5' 9\"",
                '70' => "5' 10\"",
                '71' => "5' 11\"",
                '72' => "6' 0\"",
                '73' => "6' 1\"",
                '74' => "6' 2\"",
                '75' => "6' 3\"",
                '76' => "6' 4\"",
                '77' => "6' 5\"",
                '78' => "6' 6\"",
                '79' => "6' 7\"",
                '80' => "6' 8\"",
                '81' => "6' 9\"",
                '82' => "6' 10\"",
                '83' => "6' 11\"",
                '84' => "7' 0\"",
                ])
            ->placeholder('Required height')
            ->required()
        !!}
        {!! Former::select('division_preference_first')
            ->addClass('form-control')
            ->options(['mens' => 'Mens', 'mixed' => 'Mixed', 'womens' => 'Womens'])
            ->placeholder('Required first division preference')
            ->required()
        !!}
        {!! Former::select('division_preference_second')
            ->addClass('form-control')
            ->options(['mens' => 'Mens', 'mixed' => 'Mixed', 'womens' => 'Womens'])
            ->placeholder('Optional second division preference')
        !!}
        {!! Former::password('password')
            ->addClass('form-control')
            ->placeholder('Required password')
            ->required()
        !!}
        {!! Former::password('password_confirmation')
            ->addClass('form-control')
            ->label('Password (again)')
            ->placeholder('Required password confirmation')
            ->required()
        !!}
    </div>

    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Sign up')
        !!}
    </div>
    {!! Former::close() !!}
</div>