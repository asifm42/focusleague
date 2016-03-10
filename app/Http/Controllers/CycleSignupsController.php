<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\UserSignedUpForCycle;
use App\Exceptions\UnauthorizedAccessException;
use App\Http\Requests;
use App\Http\Requests\StoreCycleSignupRequest;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\User;
use Former;

class CycleSignupsController extends Controller
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
        $cycle = Cycle::findOrFail($id);
        $user = auth()->user();

        return view('cycles.signups.create')
                ->withCycle($cycle)
                ->withUser($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCycleSignupRequest $request, $id)
    {
        $cycle = Cycle::findOrFail($id);
        $user = auth()->user();

        $cycle->signups()->attach($user->id, [
            'div_pref_first'    => $request->input('div_pref_first'),
            'div_pref_second'   => $request->input('div_pref_second'),
            'will_captain'      => $request->input('will_captain'),
            'note'              => $request->input('note'),
        ]);

        foreach ($request->input('weeks') as $weekID => $attending){
            $user->availability()->attach($weekID, [
                'attending' => $attending
            ]);
        }

        $signup_id = $cycle->signups()->find($user->id)->pivot->id;

        $signup = CycleSignup::findOrFail($signup_id);

        event(new UserSignedUpForCycle($user, $cycle, $signup));

        return redirect()->route('cycles.view', $cycle->id);
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
    public function edit(Request $request, $id)
    {
        if ($request->is('cycles/*')) {
            $user = auth()->user();
            $cycle = Cycle::findOrFail($id);
            $signup = CycleSignup::findOrFail($user->current_cycle_signup()->pivot->id);
        } elseif ($request->is('cyclesignups/*')) {
            $signup = CycleSignup::findOrFail($id);
            $signup->load('cycle','user')->first();
            $user = $signup->user;
            $cycle = $signup->cycle;
        }

        if ( auth()->user()->cannot('update', $signup) ) {
            throw new UnauthorizedAccessException;
        }

        Former::populate($signup);
        return view('cycles.signups.edit')
                ->withCycle($cycle)
                ->withUser($user)
                ->withSignup($signup);
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
        if ($request->is('cycles/*')) {
            $cycle = Cycle::findOrFail($id);
            $user = auth()->user();
        } elseif ($request->is('cyclesignups/*')) {
            $signup = CycleSignup::findOrFail($id);
            $signup->load('cycle','user')->first();
            $cycle = $signup->cycle;
            $user = $signup->user;
        }

        $cycle->signups()->updateExistingPivot($user->id, [
            'div_pref_first'    => $request->input('div_pref_first'),
            'div_pref_second'   => $request->input('div_pref_second'),
            'will_captain'      => $request->input('will_captain'),
            'note'              => $request->input('note'),
        ]);

        foreach ($request->input('weeks') as $weekID => $attending){
            $user->availability()->updateExistingPivot($weekID, [
                'attending' => $attending
            ]);
        }

        return redirect()->route('cycles.view', $cycle->id);
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
