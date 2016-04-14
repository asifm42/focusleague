<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Sign in</h2>
    </div>
    {!! Former::vertical_open()
        ->action(route('sessions.signin'))
    !!}

    <div class="panel-body">

        {!! Former::text('email')
            ->addClass('form-control')
            ->placeholder('Required email address')
            ->autofocus('autofocus')
        !!}

        {!! Former::password('password')
            ->addClass('form-control')
            ->placeholder('Required password')
        !!}

        <div class="row">
            <div class="col-xs-6">
                <div class="checkbox">
                    <label>{!! Form::checkbox('remember_me', 'true') !!} Remember me</label>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="checkbox pull-right">
                    <a href="{!! route('password.emailForm') !!}">Forgot password?</a>
                </div>
            </div>
        </div>

    </div>

    <div class="panel-footer">
        {!! Former::submit()
            ->addClass('btn btn-primary')
            ->value('Sign in')
        !!}
    </div>

    {!! Former::close() !!}
</div>
<a href="{{ route('users.create')}}" class="btn btn-info btn-block">Need a player account? Get one here.</a>

