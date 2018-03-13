<h3 class="text-center">Sign in</h3>

<form accept-charset="utf-8" class="form-vertical" method="POST" action="{{ route('sessions.signin') }}">
    <div class="card mt-4 mb-4">
        <div class="card-body">
                <div class="form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
                    <label for="email" class="required">Email</label>
                    <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" aria-describedby="emailHelp" required placeholder="Required email">
                    <div id="emailHelp" class="invalid-feedback">{{ $errors->has('email') ? $errors->first('email') : '' }}</div>
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-danger' : ''}}">
                    <label for="password" class="required">Password</label>
                    <input name="password" type="password" class="form-control" id="password" aria-describedby="passwordHelp" required placeholder="Required password">
                </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="true">
                                Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="checkbox float-right">
                        <a href="{!! route('password.request') !!}">Forgot password?</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input class="btn btn btn-primary btn-block" type="submit" value="Sign in">
    {{ csrf_field() }}
</form>

<p><a href="{{ route('users.create')}}" class="btn btn-link btn-block mt-3">Need a player account? Get one here.</a></p>