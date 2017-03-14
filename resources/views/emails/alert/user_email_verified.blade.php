A new user was verified for FOCUS League on {{ $user->updated_at->toDayDateTimeString() }}

Name:
    {{ $user->name }}

Nickame:
    {{ $user->nickname }}

Email:
    {{ $user->email }}

Environment:
    {{ App::environment() }}
