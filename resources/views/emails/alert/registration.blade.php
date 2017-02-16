A new user was registered for FOCUS League on {{ $user->updated_at->toDayDateTimeString() }}

Name:
    {{ $user->name }}

Nickame:
    {{ $user->nickname }}

Email:
    {{ $user->email }}

Gender:
    {{ $user->gender }}

Dominant Hand:
    {{ $user->dominant_hand }}

Height:
    {{ $user->height }}

Division preference:
    First: {{ $user->division_preference_first }}
    Second: {{ $user->division_preference_second }}

Cell Number:
    {{ $user->cell_number }}

Birthday:
    {{ $user->birthday }}

Environment:
    {{ App::environment() }}
