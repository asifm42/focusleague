@extends('layouts.default')
@section('title','FOCUS League – Resend verification email')
@section('content')

    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Resend verification email</h4>
            <h3 class="hidden-xs hidden-sm">Resend verification email</h3>
            <p>Complete the form below to resend the verification email</p>
        </div>
    </div>

    <div class="container">
        <div class ="row">
            <div class="col-md-8">
                <div class="panel panel-default">

                    {!! Former::vertical_open()
                        ->method('POST')
                        ->action(route('users.resetVerificationCode'))
                    !!}

                    <div class="panel-body">
                        <p class="text-muted">Haven't received the verification email? Not finding it in your spam/junk folder? Don't worry, enter your email below and we'll resend it.</p>
                        {!! Former::text('email')
                            ->addClass('form-control')
                            ->placeholder('Required email address')
                            ->autofocus('autofocus')
                        !!}
                    </div>

                    <div class="panel-footer">
                        {!! Form::submit('Send verification', array('class' => 'btn btn-primary')) !!}
                    </div>

                    {!! Former::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection