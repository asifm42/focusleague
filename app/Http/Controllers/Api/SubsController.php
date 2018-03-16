<?php

namespace App\Http\Controllers\Api;

use App\Events\UserSignedUpAsASub;
use App\Events\UserUpdatedSubSignup;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UpdateSubSignupRequest;
use App\Models\Sub;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cycle)
    {
        $cycle->load('weeks');

        foreach($request->input('weeks') as $week){
            $week = $cycle->weeks->find($week);

            $week->subs()->attach(auth()->user()->id, ['note'=>$request->input('note')]);

            $sub = Sub::findOrFail($week->subs()->where('user_id', auth()->user()->id)->first()->pivot->id);

            event(new UserSignedUpAsASub($sub));
        }

        flash()->success('You are signed up to sub!');

        return response()->json([
            'status' => 'success'
        ]);
        //return redirect()->route('users.dashboard');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubSignupRequest $request, $id)
    {
        // $sub = Sub::findOrFail($id);
        // $sub->load('user', 'week');
        // $user = $sub->user;

        // $cycle = $sub->week->cycle;
        // $cycle->load('weeks', 'signups', 'weeks.subs');

        // $week = $cycle->weeks->find($request->input('week'));

        // $sub->week()->associate($week);
        // $sub->note = $request->input('note');

        // $sub->save();
        // // $week->subs()->attach(auth()->user()->id, ['note'=>$request->input('note')]);

        // event(new UserUpdatedSubSignup(auth()->user(), $week, $sub));

        // if (auth()->user()->isAdmin()) {
        //     flash()->success('<a href="'.route('sub.edit', $sub->id).'"">Sub signup for ' . $user->name . '</a> has been updated.');

        //     return redirect()->route('users.show', $user->id);
        // }

        // flash()->success('Your sub signup has been updated.');

        // return redirect()->route('users.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $sub = Sub::findOrFail($id);

        // $sub->delete();

        // flash()->success('Sub sign-up deleted');

        // return redirect()->route('users.dashboard');
    }
}
