<h3 class="text-center">Contact Us</h3>
<p class="text-center">Got a question or feedback? Get in touch!</p>
<form accept-charset="utf-8" class="form-vertical" method="POST" action="{{ route('contact.send') }}">
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="form-group {{ $errors->has('name') ? 'has-danger' : ''}}">
                <label for="name" class="required">Name</label>
                <input name="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" aria-describedby="nameHelp" placeholder="Required first & last name" required value="{{ auth()->check() ? auth()->user()->name : old('name', '') }}" {{ auth()->check() ? 'readonly' : '' }}>
                <small id="nameHelp" class="form-text text-muted">Please provide first and last name.</small>
                <div id="nameFeedback" class="invalid-feedback">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-danger' : ''}}">
                <label for="email" class="required">Email</label>
                <input name="email" type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" id="email" aria-describedby="emailHelp" placeholder="Required email" required value="{{ auth()->check() ? auth()->user()->email : old('email', '') }}" {{ auth()->check() ? 'readonly' : '' }}>
                <div id="emailFeedback" class="invalid-feedback">{{ $errors->has('email') ? $errors->first('email') : '' }}</div>
            </div>
            <div class="form-group {{ $errors->has('message') ? 'has-danger' : ''}}">
                <label for="message" class="required">Message</label>
                <textarea name="message" class="form-control {{ $errors->has('message') ? 'is-invalid' : ''}}" id="message" rows="5" aria-describedby="messageHelp" placeholder="Required message" required>{{ old('message') }}</textarea>
                <div id="messageFeedback" class="invalid-feedback">{{ $errors->has('message') ? $errors->first('message') : '' }}</div>
            </div>
            <div class="form-group mb-0 {{ $errors->has('humancaptcha') ? 'has-danger' : ''}}">
                <label for="humancaptcha" class="required">What is the force?</label>
                <input name="humancaptcha" type="text" class="form-control {{ $errors->has('humancaptcha') ? 'is-invalid' : ''}}" id="humancaptcha" aria-describedby="humancaptchaHelp" placeholder="Name one of the 2 common throws" value={{ old('humancaptcha', $user->humancaptcha) }}>
                <small id="humancaptchaHelp" class="form-text text-muted">Just checking if a human is submitting this form.</small>
                <div id="humancaptchaFeedback" class="invalid-feedback">{{ $errors->has('humancaptcha') ? $errors->first('humancaptcha') : '' }}</div>
            </div>
        </div>
    </div>
    <input class="btn btn btn-primary btn-block" type="submit" value="Send">
    {{ csrf_field() }}
</form>

