<?php

namespace App\Http\Controllers\Api;

use App\Events\UserSignedUpForCycle;
use App\Exceptions\UnauthorizedAccessException;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\StoreCycleSignupRequest;
use App\Models\Cycle;
use App\Models\CycleSignup;
use App\Models\User;
use Former;
use Illuminate\Http\Request;

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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCycleSignupRequest $request, $cycle)
    {
        $user = auth()->user();

        // check to see if user already has a deleted signup at this point.
        $signup = auth()->user()->signups()->onlyTrashed()->get()->whereIn('cycle_id', $cycle->id)->first();

        if ($signup) {
            $signup->restore();

            $signup->update([
                'div_pref_first'    => $request->input('div_pref_first'),
                'div_pref_second'   => $request->input('div_pref_second'),
                'will_captain'      => $request->input('will_captain'),
                'note'              => $request->input('note'),
            ]);

            foreach ($request->input('weeks') as $week) {
                $user->availability()->updateExistingPivot($week['id'], [
                    'attending' => $week['attending']
                ]);
            }
        } else {
            $cycle->signups()->attach($user->id, [
                'div_pref_first'    => $request->input('div_pref_first'),
                'div_pref_second'   => $request->input('div_pref_second'),
                'will_captain'      => $request->input('will_captain'),
                'note'              => $request->input('note'),
                'payment_method'    => $request->input('payment_method'),
            ]);

            foreach ($request->input('weeks') as $week) {
                $user->availability()->attach($week['id'], [
                    'attending' => $week['attending']
                ]);
            }

            $signup_id = $cycle->signups()->find($user->id)->pivot->id;

            $signup = CycleSignup::findOrFail($signup_id);

            event(new UserSignedUpForCycle($user, $cycle, $signup));
        }

        return response()->json([
            'status' => 'success'
        ]);
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
    public function update(Request $request, $id)
    {
        // if ($request->is('cycles/*')) {
        //     $cycle = Cycle::findOrFail($id);
        //     $user = auth()->user();
        // } elseif ($request->is('cyclesignups/*')) {
        //     $signup = CycleSignup::findOrFail($id);
        //     $signup->load('cycle','user')->first();
        //     $cycle = $signup->cycle;
        //     $user = $signup->user;
        // }

        // $cycle->signups()->updateExistingPivot($user->id, [
        //     'div_pref_first'    => $request->input('div_pref_first'),
        //     'div_pref_second'   => $request->input('div_pref_second'),
        //     'will_captain'      => $request->input('will_captain'),
        //     'note'              => $request->input('note'),
        // ]);

        // foreach ($request->input('weeks') as $weekID => $attending){
        //     $user->availability()->updateExistingPivot($weekID, [
        //         'attending' => $attending
        //     ]);
        // }

        // return redirect()->route('cycles.view', $cycle->id);
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
       //  $cycleSignup = CycleSignup::findOrFail($id);

       //  if ($request->has('team_id')) {
       //      $cycleSignup->team_id = $request->input('team_id');
       //  }

       //  if ($request->has('captain')) {
       //      $cycleSignup->captain = $request->input('captain');
       //  }

       //  $cycleSignup->save();

       //  \Debugbar::info($request->all());

       // return response()->json($cycleSignup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $signup)
    {
        $signup->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
