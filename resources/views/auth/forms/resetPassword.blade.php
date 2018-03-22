<div class="row justify-content-center">
    <div class="col">
        <h3 class="text-center">Reset password?</h3>
         <form accept-charset="utf-8" class="form-vertical" method="POST" action="{{ url('password/reset') }}">
            <div class="card">
                <div class="card-body">
                    <div class="form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
                        <label for="email" class="required">Email</label>
                        <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" aria-describedby="emailHelp" required placeholder="Required email" value="{{ old('email') }}">
                        <div id="emailHelp" class="invalid-feedback">{{ $errors->has('email') ? $errors->first('email') : '' }}</div>
                    </div>

                    <div class="form-group {{ $errors->has('password') ? 'has-danger' : ''}}">
                        <label for="password" class="required">Password</label>
                        <input name="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}} password-js" id="password" aria-describedby="passwordHelp" placeholder="Required password" required>
                        <small id="passwordHelp" class="form-text text-muted">Minimum 8 characters. Case-sensitive.</small>
                        <div id="emailHelp" class="invalid-feedback">{{ $errors->has('password') ? $errors->first('password') : '' }}</div>
                    </div>

                    <div class="form-group mb-0 {{ $errors->has('password_confirmation') ? 'has-danger' : ''}}">
                        <label for="password_confirmation" class="required">Password (again)</label>
                        <input name="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : ''}} password_confirmation-js" id="password_confirmation" aria-describedby="password_confirmationHelp" placeholder="Required password confirmation">
                        <div id="emailHelp" class="invalid-feedback">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</div>
                    </div>
                </div>
            </div>
            <input class="btn btn btn-primary btn-block mt-3" type="submit" value="Reset Password">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
        </form>
    </div>
</div>
