@extends('layouts.default')
@section('title','FOCUS League – Welcome')
@section('styles')
    <style>
/*        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
        }

        .container {
            margin: 4px;
            padding: 2px;
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }*/

        .title {
            font-size: 96px;
        }

        .subtitle {
            font-size: 42px;
        }

/*        .jumbotron {
            font-weight:350;
        }*/

        .nowrap {
            white-space: nowrap;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="text-center hidden-md hidden-lg">
                    <h3>FOCUS League</h3>
                    <h5><strong>F</strong>ostering <strong>O</strong>rganized <strong>C</strong>ompetitive <strong>U</strong>ltimate <strong>S</strong>eries</h5>
                    <h6>Every Tuesday, 8p-10p, starting March 15 at the Houston Sports Park</h6>
                    <div class="jumbotron">
                        <h4>The Mission</h4>
                        <p>To structure would-be pickup games into a league and increase the availability of competitive Ultimate in Houston.</p>
                    </div>
                </div>
                <div class="text-center hidden-xs hidden-sm">
                    <h1>FOCUS League</h1>
                    <h3><strong>F</strong>ostering <strong>O</strong>rganized <strong>C</strong>ompetitive <strong>U</strong>ltimate <strong>S</strong>eries</h3>
                    <h5>Every Tuesday, 8p-10p, starting March 15 at the Houston Sports Park</h5>
                    <div class="jumbotron">
                        <h4>The Mission</h4>
                        <p>To structure would-be pickup games into a league and increase the availability of competitive Ultimate in Houston.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
