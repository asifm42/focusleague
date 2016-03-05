@extends('layouts.default')
@section('title','FOCUS League – News')

@section('content')
    <div class="page-header">
        <div class="container">
            <h4 class="hidden-md hidden-lg">News</h4>
            <h3 class="hidden-xs hidden-sm">News</h3>
            <p>News updates for the FOCUS League community</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                @foreach($posts as $post)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ $post->title }}</h4>
                        <p><small>{{ $post->created_at->toFormattedDateString() }} by {{ $post->author->nickname }}</small></p>
                    </div>
                    <div class="panel-body">
                            <p>{!! $post->content !!}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection