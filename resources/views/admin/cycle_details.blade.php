@extends('layouts.default')
@section('title','FOCUS League – Admin Cycle Overview')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h4 class="">Admin Cycle Overview</h4>
            </div>
        </div>
        <div class="row">
            <div class="col col-md-6">
            @if(!empty($cycle))
                <div class="card">
                    <div class="card-header">Cycle Details</div>
                    <div class="card-body">
                        <dl class="horizontal">
                            <dt>Name</dt>
                            <dd>{{ $cycle->name }}</dd>
                            <dt>Format</dt>
                            <dd>{!! $cycle->format !!}</dd>
                            <dt>Starts At</dt>
                            <dd>{{ $cycle->starts_at->toDayDateTimeString() }}</dd>
                            <dt>Ends At</dt>
                            <dd>{{ $cycle->ends_at->toDayDateTimeString() }}</dd>
                            <dt>Weeks</dt>
                            <dd>
                            <ul class='list-unstyled'>
                                @foreach($cycle->weeks as $week)
                                    <li>Week {{ ($week->index()) . ' - ' . $week->starts_at->toFormattedDateString() }}</li>
                                @endforeach
                            </ul>
                        </dd>
                        </dl>
                    </div>
                </div>
            @endif
            </div>
        </div>



        <div class="row">
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$mensOnly, 'cycle'=>$cycle, 'title' => 'Mens only'])
            </div>
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$mensFlexible, 'cycle'=>$cycle, 'title' => 'Mens flexible'])
            </div>
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$mixedFlexibleMale, 'cycle'=>$cycle, 'title' => 'Mixed flexible - male'])
            </div>
        </div>



        <div class="row">

            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$womensOnly, 'cycle'=>$cycle, 'title' => 'Womens only'])
            </div>
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$womensFlexible, 'cycle'=>$cycle, 'title' => 'Womens flexible'])
            </div>
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$mixedFlexibleFemale, 'cycle'=>$cycle, 'title' => 'Mixed flexible - female'])
            </div>

        </div>
        <div class="row">
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$mixedOnlyMale, 'cycle'=>$cycle, 'title' => 'Mixed only - male'])
            </div>
            <div class="col col-md-4">
            @include('signups.card', $data = ['signups'=>$mixedOnlyFemale, 'cycle'=>$cycle, 'title' => 'Mixed only - female'])
            </div>
        </div>
    </div>
@endsection