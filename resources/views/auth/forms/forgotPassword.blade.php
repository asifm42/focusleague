<h3>Forgot your password?</h3>
<p>Don't worry, it happens to all of us. Enter your email address below and we'll send you password reset instructions.</p>
<form accept-charset="utf-8" class="form-vertical" method="POST" action="{{ url('password/email') }}">
    <div class="form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
        <label for="email" class="required">Email</label>
        <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" aria-describedby="emailHelp" required placeholder="Required email">
        <div id="emailHelp" class="invalid-feedback">{{ $errors->has('email') ? $errors->first('email') : '' }}</div>
    </div>
    <input class="btn btn btn-primary btn-block" type="submit" value="Send instructions">
    {{ csrf_field() }}
</form>


