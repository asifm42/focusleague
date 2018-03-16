@extends('layouts.default')
@section('title','FOCUS League – Cycle Sign-up')
@section('styles')
<style>
time.icon
{
  font-size: 0.9em; /* change icon size */
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
</style>
@endsection
@section('content')

<div id="app">
    <h5 class="text-center">Cycle {{ $cycle->name }} Sign-up</h5>
    <cycle-signup
        :user="{{ $user->toJson() }}"
        :cycle="{{ $cycle->toJson() }}"
    ></cycle-signup>
</div>
    {{-- <div class="container"> --}}
{{--          <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                    <h3 class="text-center">Cycle {{ $cycle->name }} Sign-up</h3>
                    <p class="text-center">Sign up for the cycle</p>
                @include('cycles.signups.forms.create', ['edit'=>false])
            </div>
        </div> --}}
{{--         <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                @include('cycles.signups.forms.create2', ['edit'=>false])
            </div>
        </div> --}}
    </div>
@endsection