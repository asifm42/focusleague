@extends('layouts.default')
@section('title','FOCUS League – Resend verification email')
@section('content')

    <div class="container">
        <div class ="row justify-content-center">
            <div class="col col-md-6">
                <form accept-charset="utf-8" class="form-vertical" method="POST" action="{{ route('users.resetVerificationCode') }}">
                <h5 class='text-center'>Resend verification email</h5>
                <div class="card">

                    <div class="card-body">
                        <p class="text-warning">Haven't received the verification email? Not finding it in your spam/junk folder? Don't worry, enter your email below and we'll resend it.</p>
                        <div class="form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
                            <label for="email" class="required">Email</label>
                            <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" aria-describedby="emailHelp" required placeholder="Required email" value={{ old('email') }}>
                            <div id="emailFeedback" class="invalid-feedback">{{ $errors->has('email') ? $errors->first('email') : '' }}</div>
                        </div>
                    </div>
                </div>

                    <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Send verification">

                    {{ csrf_field() }}
                    </form>
            </div>
        </div>
    </div>

@endsection