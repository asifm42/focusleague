@component('emails.layouts.message', [ 'greeting' => 'Captains,' ])
@if($week->starts_at->isToday())
###Sub assignments for today (Cycle {{ $week->cycle->name }} - Wk{{ $week->index() }})
@else
###Sub assignments for {{ $week->starts_at->toFormattedDateString() }} (Cycle {{ $week->cycle->name }} - Wk{{ $week->index() }})
@endif

@if($week->cycle->teams()->where('division', 'mens')->get()->count() > 0)
@component('mail::panel')
<h2 style="text-align: center;" markdown="1">MENS</h2>
@foreach($week->cycle->teams()->where('division', 'mens')->get() as $team)

**Team {{ $team->name }}**
@forelse($week->subs()->wherePivot('team_id', $team->id)->get() as $sub)
* {{ $sub->nickname }} ({{ $sub->name }}) - {{ $sub->email }}
@empty
* no subs
@endforelse
@endforeach
@endcomponent
@endif

@if($week->cycle->teams()->where('division', 'mixed')->get()->count() > 0)
@component('mail::panel')
<h2 style="text-align: center;" markdown="1">MIXED</h2>
@foreach($week->cycle->teams()->where('division', 'mixed')->get() as $team)

**Team {{ $team->name }}**
@forelse($week->subs()->wherePivot('team_id', $team->id)->get() as $sub)
* {{ $sub->nickname }} ({{ $sub->name }}) - {{ $sub->email }}
@empty
* no subs
@endforelse
@endforeach
@endcomponent
@endif

@if($week->cycle->teams()->where('division', 'womens')->get()->count() > 0)
@component('mail::panel')
<h2 style="text-align: center;" markdown="1">WOMENS</h2>
@foreach($week->cycle->teams()->where('division', 'womens')->get() as $team)

**Team {{ $team->name }}**
@forelse($week->subs()->wherePivot('team_id', $team->id)->get() as $sub)
* {{ $sub->nickname }} ({{ $sub->name }}) - {{ $sub->email }}
@empty
* no subs
@endforelse
@endforeach
@endcomponent
@endif

[Cycle {{ $week->cycle->name }} details]({{ route('cycles.view', $week->cycle->id) }})

Once again, thanks for captaining, the FOCUS League wouldn't be possible without your leadership.

@endcomponent