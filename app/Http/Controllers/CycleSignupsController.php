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
        if ($id === 'current') {
            $cycle = Cycle::currentCycle();
            if (!$cycle) {
                flash()->info('Sorry, there is no current cycle at the moment.');

                return redirect()->route('cycles.index');
            }
        } else {
            $cycle = Cycle::findOrFail($id);
        }
        $user = auth()->user();

        // If user already has a signup redirect to edit form
        if ($user->cycles()->find($cycle->id)) {
            return redirect()->route('cycle.signup.edit', $cycle->id);
        } else if ($cycle->isSubbing($user)) {
            return redirect()->route('cycle.subs.edit', $cycle->id);
        }

        return view('cycles.signups.create')
                ->withCycle($cycle->load('weeks'))
                ->withUser($user)
                ->withCost(config('focus.cost'));
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

        // If user already has a signup redirect to edit form
        if ($user->cycles()->find($cycle->id)) {
            return redirect()->route('cycle.signup.edit', $cycle->id);
        }

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

            // If user already has a sub signup redirect to edit form
            if ($cycle->isSubbing($user)) {
                return redirect()->route('cycle.subs.edit', $cycle->id);
            }

            $signup = CycleSignup::find($user->current_cycle_signup()->pivot->id);
        } elseif ($request->is('cyclesignups/*')) {
            $signup = CycleSignup::findOrFail($id);
            // $signup->load('cycle.weeks','user')->first();
            $user = $signup->user;
            $cycle = $signup->cycle;
        }

        $signup->load('cycle.weeks', 'user');
        $cycle->load('weeks');

        // if sign up is not open and user is not an admin, redirect back
        // if ($cycle->status() !== "SIGNUP_OPEN" && ! $user->isAdmin()){
        //     flash()->error('Sorry, editing your sign-up is not possible. Please use the contact us page to share your schedule change.');
        //     return redirect()->back();
        // }

        if ( auth()->user()->cannot('update', $signup) ) {
            throw new UnauthorizedAccessException;
        }

        $availability = $user->availability()->whereIn('week_id', $cycle->weeks->pluck('id'))->get();

        // fire off event

        return view('cycles.signups.edit')
                ->withCycle($cycle)
                ->withUser($user)
                ->withSignup($signup)
                ->withAvailability($availability)
                ->withCost(config('focus.cost'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apiUpdate(Request $request, $id)
    {
        $cycleSignup = CycleSignup::findOrFail($id);

        if ($request->has('team_id')) {
            $cycleSignup->team_id = $request->input('team_id');
        }

        if ($request->has('captain')) {
            $cycleSignup->captain = $request->input('captain');
        }

        $cycleSignup->save();

        \Debugbar::info($request->all());

       return response()->json($cycleSignup);
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
