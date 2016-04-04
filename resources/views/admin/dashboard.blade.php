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
                            <dt>Name:</dt>
                            <dd>{{ $current_cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{{ $current_cycle->format }}</dd>
                            <dt>Teams published?</dt>
                            <dd>{{ ($current_cycle->teams_publised) ? 'Yes' : 'No' }}</dd>
                            <dt>Status</dt>
                            <dd>{{ $current_cycle->status() }}</dd>
                        </dl>
                        <a href="{{ route('admin.cycle.details', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Admin overview</a>
                        @if (!$current_cycle->teams_publised)
                            <a href="{{ route('cycle.teams.create', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Team Builder</a>
                            <a href="{{-- {{ route('games.create', $current_cycle->id) }} --}}" class="btn btn-default btn-lg btn-block">Schedule Builder</a>
                            <a href="{{ route('cycle.teams.publish', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Publish teams</a>
                        @else
                            <a href="{{ route('cycle.teams.unpublish', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Place a sub</a>
                            <a href="{{ route('cycle.teams.unpublish', $current_cycle->id) }}" class="btn btn-default btn-lg btn-block">Unpublish teams</a>
                        @endif
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