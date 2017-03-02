A new sub signup for FOCUS League Cycle {{ $sub->week->cycle->name }} Wk{{ $sub->week->index() }} at {{ $sub->created_at->toDayDateTimeString() }}

Nickname:
    {{ $sub->user->nickname }}

Name:
    {{ $sub->user->name }}

Email:
    {{ $sub->user->email }}

Date:
    {{ $sub->week->starts_at->toFormattedDateString() }}

Note:
    {{ $sub->note }}






Environment:
    {{ App::environment() }}
