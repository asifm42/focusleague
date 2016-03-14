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
                        </dl>
                    </div>
                </div>
            @endif
            </div>
        </div>



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
    </div>
@endsection