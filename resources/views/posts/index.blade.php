@extends('layouts.default')
@section('title','FOCUS League – News')

@section('content')
    <div class="page-header">
        <div class="container"><!--
            <h4 class="hidden-md hidden-lg">News</h4>
            <h3 class="hidden-xs hidden-sm">News</h3> -->
            <h3 class="">News</h3>
            <p>News updates for the FOCUS League community</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 ">
                @foreach($posts as $post)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <!-- <h5 class="hidden-md hidden-lg">{{ $post->title }}</h5> -->
                        <!-- <h4 class="hidden-xs hidden-sm">{{ $post->title }}</h4> -->
                        <h5 class="">{{ $post->title }}</h5>
                        <p><small>{{ $post->created_at->toFormattedDateString() }} by {{ $post->author->nickname }}</small></p>
                    </div>
                    <div class="panel-body">
                        <p>{!! html_entity_decode($post->content) !!}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection