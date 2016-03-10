<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Forgot password?</h2>
    </div>
    {!! Former::vertical_open()
        ->action(url('password/email'))
        ->method('POST')
    !!}

    <div class="panel-body">

        {!! Former::text('email')
            ->addClass('form-control')
            ->placeholder('Required email address')
            ->autofocus('autofocus')
        !!}

    </div>

    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Send instructions')
        !!}
    </div>

    {!! Former::close() !!}
</div>

