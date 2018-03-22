@if ($cycle_signup)
    @if($cycle->areTeamsPublished())
        @if (is_null($cycle_signup->pivot->team_id))
            <dd>You are signed up but not placed on a team yet.</dd>
        @else
            <dd>Team <em>{{ucwords($cycle->teams->find($cycle_signup->pivot->team_id)->name)}} {!! $cycle->teams->find($cycle_signup->pivot->team_id)->divisionIcon() !!}</em></dd>
        @endif

        @if ($cycle_signup->captain)
            <dd>You are a captain. Thanks!</dd>
        @endif
    @else
        <dd>You are signed up!</dd>
        <dd>Teams will be published before game time.</dd>
    @endif

    @include('signups.self-status-table', ['cycle' => $cycle, 'cycle_signup' => $cycle_signup])
        {{--
    @if ($cycle->status() === 'SIGNUP_OPEN')
        <dd>Sign up is currently open until {{ $cycle->signup_closes_at->toDayDateTimeString() }}</dd>
    @elseif ($cycle->status() === 'SIGNUP_CLOSED')
        <dd>Sign up is currently closed but you can still make changes.</dd>
        <a class="btn btn-success btn-block" href="{{ route('cycle.signup.create', $cycle->id) }}">Edit sign up</a>
    @elseif ($cycle->status() === 'IN_PROGRESS')
<dd>Cycle is in progess. Need to update your sign-up info? <a href="{{ route('contact.create') }}">Contact us</a> and let us know.</dd>
    @endif --}}
        <a class="btn btn-primary btn-block mt-3" href="{{ route('cycle.signup.edit', $cycle->id) }}">Edit sign up</a>
@elseif($sub_weeks)
    <dd>You are signed up as a sub for the following weeks</dd>
{{--     @foreach($sub_weeks as $sub_week)
        <dd><a href="{{ route('sub.edit', $sub_week['deets']->pivot->id) }}">{{ $sub_week['week']->starts_at->toFormattedDateString() }}</a></dd>
    @endforeach
    <a class="btn btn-success btn-block" href="{{ route('sub.create', $cycle->id) }}">Add a Sub week</a> --}}
    @foreach($sub_weeks as $sub_week)
        <dd>{{ $sub_week['week']->starts_at->toFormattedDateString() }}</dd>
    @endforeach
    <a class="btn btn-primary btn-block" href="{{ route('cycle.subs.edit', $cycle->id) }}">Edit sign-up</a>
@else
    <dd>You are NOT signed up.</dd>
    @if ($cycle->status() === 'SIGNUP_OPENS_LATER')
        <dd>Sign up opens at {{ $cycle->signup_opens_at->toDayDateTimeString() }}</dd>
    @elseif ($cycle->status() === 'SIGNUP_OPEN')
        <dd>Sign up is currently open until {{ $cycle->signup_closes_at->toDayDateTimeString() }}</dd>
        <a class="btn btn-success btn-block" href="{{ route('cycle.signup.create', $cycle->id) }}">Sign up</a>
    @elseif ($cycle->status() === 'SIGNUP_CLOSED')
        <dd>Sign up is currently closed. Still taking late signups or subs.</dd>
        <a class="btn btn-success btn-block" href="{{ route('cycle.signup.create', $cycle->id) }}">Sign up</a>
    @elseif ($cycle->status() === 'IN_PROGRESS')
        <dd>Cycle is in progess. Sign-ups are closed but you can sign up as a sub.</dd>
        <a class="btn btn-success btn-block" href="{{ route('cycle.signup.create', $cycle->id) }}">Sign up</a>
    @elseif ($cycle->status() === 'COMPLETED')
        <dd>Completed</dd>
    @endif
@endif

@if (request()->is('dashboard'))
    <a class="btn btn-info btn-block mt-3" href="{{ route('cycles.view', $cycle->id) }}">Cycle Details</a>
@endif