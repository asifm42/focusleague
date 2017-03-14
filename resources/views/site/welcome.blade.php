@extends('layouts.default')
@section('title','FOCUS League – Welcome')
@section('styles')
<style>

time.icon
{
  font-size: 0.8em; /* change icon size */
  display: inline-block;
  position: relative;
  width: 6em;
  height: 6.5em;
  background-color: #fff;
  border-radius: 0.6em;
  border: 1px solid #2196f3;
  /*border: 1px solid #c1c1c1;*/
  /*box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;*/
  overflow: hidden;
}

time.icon *
{
  display: block;
  width: 100%;
  font-size: 1em;
  font-weight: bold;
  font-style: normal;
  text-align: center;
}

time.icon strong
{
  position: absolute;
  top: 0;
  padding: 0.2em 0;
  color: #fff;
  background-color: #2196f3;
  /*border-bottom: 1px dashed #f37302;*/
  /*box-shadow: 0 2px 0 #fd9f1b;*/
}

time.icon em
{
  position: absolute;
  bottom: 0.2em;
  color: #2196f3;
  font-size: 0.8em;
}

time.icon span
{
  font-size: 2.25em;
  letter-spacing: -0.05em;
  padding-top: .8em;
  color: #2f2f2f;
}

div.event  {/*
    display: inline-block;
    line-height: 5em;
    vertical-align: top;*/
    padding-left: 10px;
    font-size: 1.1em;
}

.schedule > li,
.schedule-list > li {
}

.schedule > li {
    display:block;
    padding:8px;
}

.schedule-list > li {
    display:flex;
    align-items:center;
    padding:10px;
}

.schedule-list > .list-group-item:first-child {
    border-radius: 0;
}
.schedule-list > .list-group-item:last-child {
    border-radius: 0;
    border-bottom: 0;
    display: block;
    padding:8px;
}

.schedule {
    max-height:433px;
}

.schedule-list {
    max-height:365px;
    overflow-x: hidden;
    overflow-y: scroll;
    border-bottom:solid #ddd 1px;
    border-bottom-left-radius:3px;
    border-bottom-right-radius:3px;
}

</style>
@stop

@section('content')
    <div class="container">
<!-- ########## START XS/SM ########## -->
        <div class="text-center hidden-md hidden-lg">
            @include('site.welcome-mobile')
        </div>
<!-- ########## END XS/SM ########## -->
<!-- ########## START MD/LG ########## -->
        <div class="text-center hidden-xs hidden-sm">
            @include('site.welcome-desktop')
        </div>
<!-- ########## END MD/LG ########## -->
    </div>
@endsection