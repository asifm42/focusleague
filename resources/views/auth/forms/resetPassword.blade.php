<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Reset password</h2>
    </div>
    {!! Former::vertical_open()
        ->method("POST")
        ->action(url('password/reset'))
    !!}

    <div class="panel-body">

        {!! Former::text('email')
            ->addClass('form-control')
            ->placeholder('Required email address')
            ->required()
            ->autofocus('autofocus')
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

        {!! Former::hidden('token')
            ->value($token)
        !!}
    </div>

    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Reset Password')
        !!}
    </div>

    {!! Former::close() !!}
</div>

