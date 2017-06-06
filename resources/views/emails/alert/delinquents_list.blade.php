Delinquents as of {{ Carbon::now()->toFormattedDateString() }}

@if($currentCycle && ($currentCycle->teams->count() > 0))
@foreach($currentCycle->teams as $team)
Team {{ $team->name }}:
@foreach($team->captains as $captain)
captain: {{ $captain->user->name }} ({{ $captain->user->getNicknameOrShortName() }}) - {{ $captain->user->email }}
@endforeach
@forelse($team->getDelinquents() as $delinquent)
    {{ $delinquent->user->name }} ({{ $delinquent->user->getNicknameOrShortName() }}) - {{ $delinquent->user->getBalanceString() }}
@empty
    No players with a balance.
@endforelse

@endforeach

Players signed up for this cycle but not on a team:

@forelse($signupsNotOnATeamWithABalance as $user)
    {{ $user->name }} ({{ $user->getNicknameOrShortName() }}) - {{ $user->getBalanceString() }}
@empty
    No signups without a team with a balance
@endforelse

Players not signed up for this cycle:

@forelse($userNotSignedUpwithABalance as $user)
    {{ $user->name }} ({{ $user->getNicknameOrShortName() }}) - {{ $user->getBalanceString() }}
@empty
    No users that haven't signed up for the current with a balance
@endforelse

@else

No current cycle. Users that have a balance:

@forelse($delinquents as $user)
    {{ $user->name }} ({{ $user->getNicknameOrShortName() }}) - {{ $user->getBalanceString() }} - {{ $user->email }} - {{ $user->cell_number }}
@empty
    No users with a balance.
@endforelse

@endif



Environment:
    {{ App::environment() }}

