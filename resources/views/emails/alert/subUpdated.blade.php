A sub signup was updated for FOCUS League Cycle {{ $sub->week->cycle->name }} Wk{{ $sub->week->index() }} at {{ $sub->updated_at->toDayDateTimeString() }}

Updated by:
    {{ $updatedBy->name }}

Nickname:
    {{ $sub->user->nickname }}

Name:
    {{ $sub->user->name }}

Email:
    {{ $sub->user->email }}

Date:
    Wk{{ $sub->week->index() }} - {{ $sub->week->starts_at->toFormattedDateString() }}

Note:
    {{ $sub->note }}


Environment:
    {{ App::environment() }}
