A new cycle signup for FOCUS League {{ $signup->cycle->name }} at {{ $signup->created_at->toDayDateTimeString() }}

Name:
    {{ $signup->user->name }}

Nickname:
    {{ $signup->user->nickname }}

Cycle:
    {{ $signup->cycle->name }}

Dates Available:
@foreach($datesAttending as $date)
    {{ $date }}
@endforeach

Dates Missing:
@foreach($datesMissing as $date)
    {{ $date }}
@endforeach

Will captain?:
    {{ $signup->will_captain }}

Div pref 1?:
    {{ $signup->div_pref_first }}

Div pref 2?:
    {{ $signup->div_pref_second }}

Note:
    {{ $signup->note }}


Environment:
    {{ App::environment() }}

