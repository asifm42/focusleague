<h3 class="text-center">Contact Us</h3>
<p class="text-center">Got a question or feedback? Get in touch!</p>
<form accept-charset="utf-8" class="form-vertical" method="POST" action="{{ route('contact.send') }}">
    <div class="card mt-4 mb-4">
        <div class="card-body">
            <div class="form-group">
                <label for="name" class="required">Name</label>
                <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp" placeholder="Required first & last name" required value="{{ auth()->check() ? auth()->user()->name : '' }}" {{ auth()->check() ? 'readonly' : '' }}>
                <small id="nameHelp" class="form-text text-muted">Please provide first and last name.</small>
            </div>
            <div class="form-group">
                <label for="email" class="required">Email</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required placeholder="Required email"value="{{ auth()->check() ? auth()->user()->email : '' }}" {{auth()->check() ? 'readonly' : ''}}>
            </div>
            <div class="form-group">
                <label for="name" class="required">Message</label>
                <textarea class="form-control" id="message" rows="5" aria-describedby="messageHelp" placeholder="Required message" required></textarea>
            </div>
        </div>
    </div>
    <input class="btn btn btn-primary btn-block" type="submit" value="Send">
    {{ csrf_field() }}
</form>
