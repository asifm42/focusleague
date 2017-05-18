@extends('layouts.default')
@section('title','FOCUS League – Admin Dashboard')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">Admin Dashboard</h4>
            <h3 class="hidden-xs hidden-sm">Admin Dashboard</h3>
            <p>Overview of system.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6">
            @if(!empty($current_cycle))
                <div class="panel panel-default">
                    <div class="panel-heading">Current Cycle</div>
                    <div class="panel-body">
                        <dl class="horizontal">
                            <dt>Name</dt>
                            <dd>{{ $current_cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{!! $current_cycle->format !!}</dd>
                            <dt>Teams published?</dt>
                            <dd>{{ ($current_cycle->teams_published) ? 'Yes' : 'No' }}</dd>
                            <dt>Status</dt>
                            <dd>{{ $current_cycle->status() }}</dd>
                        </dl>
                        <a href="{{ route('admin.cycle.details', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Admin overview</a>
                            <a href="{{ route('cycle.teams.builder', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Team Builder</a>
                        @if (! $current_cycle->teams_publised)
                            <a href="{{-- {{ route('games.create', $current_cycle->id) }} --}}" class="btn btn-default btn-lg btn-block">Schedule Builder</a>
                        @endif
<button type="button" class="btn btn-default btn-lg btn-block" data-toggle="modal" data-target="#captainEmailsModal">
    Captain Email List
</button>
<button type="button" class="btn btn-default btn-lg btn-block" data-toggle="modal" data-target="#subEmailsModal">
    Sub Email List
</button>
<button type="button" class="btn btn-default btn-lg btn-block" data-toggle="modal" data-target="#subAnnounceModal">
    Announce Subs to Subs and Captains
</button>
                    </div>
                </div>
            @endif
            </div>
            <div class="col-xs-12 col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Admin Links</div>
                    <div class="panel-body">
                        <a href="{{ route('users.list') }}" class="btn btn-default btn-lg btn-block">See all users</a>
                        <a href="{{ route('users.delinquent') }}" class="btn btn-default btn-lg btn-block">See delinquents</a>
                        <a href="{{ route('posts.create') }}" class="btn btn-default btn-lg btn-block">Create a post</a>
                        <a href="{{ route('transactions.create') }}" class="btn btn-default btn-lg btn-block">Post a transaction</a>
                    </div>
                </div>

            </div>
        </div>

{{--

        <div class="row">
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$mensOnly, 'cycle'=>$current_cycle, 'title' => 'Mens only'])
            </div>
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$mensFlexible, 'cycle'=>$current_cycle, 'title' => 'Mens flexible'])
            </div>
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$mixedFlexibleMale, 'cycle'=>$current_cycle, 'title' => 'Mixed flexible - male'])
            </div>
        </div>



        <div class="row">

            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$womensOnly, 'cycle'=>$current_cycle, 'title' => 'Womens only'])
            </div>
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$womensFlexible, 'cycle'=>$current_cycle, 'title' => 'Womens flexible'])
            </div>
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$mixedFlexibleFemale, 'cycle'=>$current_cycle, 'title' => 'Mixed flexible - female'])
            </div>

        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$mixedOnlyMale, 'cycle'=>$current_cycle, 'title' => 'Mixed only - male'])
            </div>
            <div class="col-xs-12 col-md-4">
            @include('signups.panel', $data = ['signups'=>$mixedOnlyFemale, 'cycle'=>$current_cycle, 'title' => 'Mixed only - female'])
            </div>
        </div>
        --}}
    </div>
@endsection

@section('modals')
<div class="modal fade" id="captainEmailsModal" tabindex="-1" role="dialog" aria-labelledby="captainEmailsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="captainEmailsModalLabel">Cycle {{ $current_cycle->name }} Captain Emails</h4>
            </div>
            <div class="modal-body">
                @foreach($current_cycle->teams as $team)
                    <ul class="list-unstyled">
                        <li style="border-bottom:solid 1px #ccc;"><strong>Team {{ $team->name }}</strong></li>
                        <li>
                        @foreach($team->captains as $captain)
                            {{ $captain->user->name . " <" . $captain->user->email . ">"}},
                        @endforeach
                        </li>
                    </ul>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subEmailsModal" tabindex="-1" role="dialog" aria-labelledby="subEmailsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="subEmailsModalLabel">Cycle {{ $current_cycle->name }} Sub Emails</h4>
            </div>
            <div class="modal-body">

                @for($i=0, $len=$current_cycle->weeks()->count(); $i < $len; $i++ )
                    <?php
                        $subCount = $current_cycle->weeks[$i]->subs()->count() ;
                    ?>
                    <ul class="list-unstyled">
                        <li style="border-bottom:solid 1px #ccc;"><strong>Week {{ ($i+1) }} - {{ $current_cycle->weeks[$i]->starts_at->toFormattedDateString() }}</strong><span class="badge pull-right">{{ $subCount }}</span></li>
                        <li>
                        @foreach($current_cycle->weeks[$i]->subs()->get() as $sub)
                        {{ $sub->name ." <". $sub->email .">"}},
                        @endforeach
                        </li>
                    </ul>
                @endfor
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="subAnnounceModal" tabindex="-1" role="dialog" aria-labelledby="subAnnounceModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="subEmailsAnnounceLabel">Announce Subs for Cycle {{ $current_cycle->name }} - Wk{{$current_cycle->currentWeek()->index()}}</h4>
            </div>
            <div class="modal-body">
                <p>This will send an individual email to each sub on a team confirming their spot for tonight.</p>
                <p>And it will send one email to all captains announcing this week's subs to them.</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('subs.announce', $current_cycle->currentWeek()->id)}}" type="button" class="btn btn-primary">Announce</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

@stop