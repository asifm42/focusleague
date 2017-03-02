@component('emails.layouts.message', ['user'=>$user])
<p>Cycle {{ $cycle->name }} teams have been set!</p>

<p>The format for the cycle is {{ $cycle->format }}.<p>

<p>You are on team <strong><em>{{ ucwords($team->name) }}</em></strong> in the {{ ucfirst($team->division) }} division.</p>

@if ($team->captains->count() > 1)
    <p>Your captains are:</p>
@elseif (count($team->captains) == 1)
    <p>Your captain is:</p>
@else
    <p>We are working on selecting a captain since no one volunteered. Please let us know if you have changed your mind and are willing to captain this cycle.</p>
@endif

@if ($team->captains->count() > 0)
<ul>
    @foreach($team->captains as $captain)
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

<p>Your fee for this cycle is ${{ $cost }}.00. Your current balance is {{ $user->getBalanceString() }}. Please use one of the following methods of payment (listed in order of preference). Please put "Cycle {{ $cycle->name }} fees" in the note if possible.</p>
@component('site.payment_methods', ['balance' => $user->getBalance()])
@endcomponent

<p>More details such as your team's schedule and other teams can be found on the <a href="{{ route('cycles.view', $cycle->id) }}">cycle details</a> page.</p>

<p>Games are at the <a href="https://goo.gl/maps/QCZxXVm6Ua32">Houston Sports Park</a>.</p>

<p>Please bring a white and non-grey dark jersey. Captains will be flipping for jersey color prior to start time.</p>

<p>Let's play hard. Let's play fair.</p>
@endcomponent