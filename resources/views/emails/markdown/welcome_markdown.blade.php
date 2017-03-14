@component('emails.layouts.message')
**Welcome to FOCUS League!** Your email address has now been verified and you can sign into your account at [{!! route('sessions.create') !!}]({!! route('sessions.create') !!}).

You can view your info and current cycle details at [your dashboard]({{ route('users.dashboard') }}). BUT before you can do that, we need you [share your ultimate history with us]({{ route('ultimate_history.create') }}).

Make sure to check out the [FAQ page]({{ route('site.faq') }}) so there are no surprises.

Should you ever encounter problems with your account or forget your password, we will contact you at this address.

Lets play hard and lets play fair!
@endcomponent