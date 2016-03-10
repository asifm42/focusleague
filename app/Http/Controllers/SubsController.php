<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Cycle;
use App\Models\Week;
use App\Events\UserSignedUpAsASub;

class SubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $user = auth()->user();
        $cycle = Cycle::findOrFail($id);
        $cycle->load('weeks', 'signups', 'weeks.subs');

        if ( !empty( $cycle->signups()->find($user->id) ) ){
            flash()->warning('You can not sign up as a sub because you are already signed up for this cycle.');
            return redirect()->route('cycles.view', $cycle->id);
        }

        return view('subs.create')
            ->withCycle($cycle)
            ->withUser($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // return $request->all();
        $cycle = Cycle::findOrFail($id);
        $cycle->load('weeks');

        $week = $cycle->weeks->find($request->input('week'));

        $week->subs()->attach(auth()->user()->id, ['note'=>$request->input('note')]);

        event(new UserSignedUpAsASub(auth()->user(), $week, $cycle));

        flash()->success('You are signed up to sub!');

        return redirect()->route('users.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
