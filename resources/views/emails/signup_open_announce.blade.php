@component('emails.layouts.message', ['user' => $user])
<h1>Sign-up for Cycle {{ $cycle->name }} is now open!</h1>

Cycle {{ $cycle->name }} will be {{ $cycle->weeks->count() }} weeks:
@foreach($cycle->weeks as $week)
* {{ $week->starts_at->toDayDateTimeString() }}
@endforeach

<p>Based on the availability survey, we are pleased to offer one more 3 week cycle this season. Please sign up through the website if you plan on playing this cycle regardless of your availability survey entry.</p>

@component('mail::button', ['url' => route('cycle.signup.create', $cycle->id), 'color' => 'blue'])
SIGN UP FOR CYCLE {{ $cycle->name }}
@endcomponent

<p>Thanks for your support!</p>
@slot('unsubscribe')
<p><a href="%tag_unsubscribe_url%">Unsubscribe</a> from Cycle {{ $cycle->name }} sign-up reminders.</p>
@endslot
@endcomponent