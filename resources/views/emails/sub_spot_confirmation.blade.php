@component('emails.layouts.message', [ 'user' => $sub->user ])
@if($sub->week->starts_at->isToday())
###We got a sub spot for you today (Cycle {{ $sub->week->cycle->name }} - Wk{{ $sub->week->index() }})!
@else
###We got a sub spot for you on {{ $sub->week->starts_at->toFormattedDateString() }} (Cycle {{ $sub->week->cycle->name }} - Wk{{ $sub->week->index() }})!
@endif

You are on team **_{{ ucwords($sub->team->name) }}_** in the **{{ ucfirst($sub->team->division) }}** division. Please bring a white and non-grey dark shirt. Captains will be flipping for jersey color before the game.

@if ($sub->team->captains->count() > 1)
Your captains are:
@elseif (count($sub->team->captains) == 1)
Your captain is:
@else
We are working on selecting a captain since no one volunteered. Please let us know if you have changed your mind and are willing to captain this cycle.
@endif

@if ($sub->team->captains->count() > 0)
<ul>
    @foreach($sub->team->captains as $captain)
        <li>
        @if ($captain->user->nickname)
            {{ ucwords($captain->user->name) . ' aka ' . ucwords($captain->user->nickname) }}
        @else
            {{ ucwords($captain->user->name) }}
        @endif
            {{' - ' . $captain->user->email }}
        </li>
    @endforeach
</ul>
@endif

Your sub fee for this week is ${{ $cost }}. Your current balance is {{ $sub->user->getBalanceString() }}. Please use one of the following methods of payment (listed in order of preference). Please put "Cycle {{ $sub->week->cycle->name }} - Wk{{ $sub->week->index() }} sub fee" in the note if possible.

@component('site.payment_methods', ['balance' => $sub->user->getBalanceInDollars()])
@endcomponent

<p>See who else is on your team and other <a href="{{ route('cycles.view', $sub->week->cycle->id) }}">cycle details here</a>.</p>

Once again, thanks for playing, the FOCUS League wouldn't be possible without your participation.
@endcomponent