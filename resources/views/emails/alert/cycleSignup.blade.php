A new cycle signup for FOCUS League at {{ $signup['created_at'] }}

Name:
    {{ $user['name'] }}

Nickname:
    {{ $user['nickname'] }}

Cycle:
    {{ $cycle['name'] }}

Dates Available:
@foreach($dates_attending as $date)
    {{ $date }}
@endforeach

Will captain?:
    {{ $signup['will_captain'] }}

Div pref 1?:
    {{ $signup['div_pref_first'] }}

Div pref 2?:
    {{ $signup['div_pref_second'] }}

Note:
    {{ $signup['note'] }}


Environment:
    {{ App::environment() }}

