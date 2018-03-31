<?php

namespace App\Http\Controllers\Api;

use App\Events\UserSignedUpAsASub;
use App\Events\UserUpdatedSubSignup;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UpdateSubSignupRequest;
use App\Models\Sub;
use Illuminate\Http\Request;

class CycleSubsController extends Controller
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

            // check to see if user already has a deleted sub at this point.
            $sub = auth()->user()->subs()->onlyTrashed()->get()->whereIn('week_id', $week->id)->first();

            if ($sub) {
                $sub->restore();
                $this->updateAllSubs(auth()->user(), $cycle, [
                    'div_pref_first' => $request->input('div_pref_first'),
                    'div_pref_second' => $request->input('div_pref_second'),
                    'note' => $request->input('note'),
                    'payment_method' => $request->input('payment_method')
                ]);
            } else {
                $week->subs()->attach(auth()->user()->id, [
                    'div_pref_first' => $request->input('div_pref_first'),
                    'div_pref_second' => $request->input('div_pref_second'),
                    'note' => $request->input('note'),
                    'payment_method' => $request->input('payment_method')
                ]);

                $sub = Sub::findOrFail($week->subs()->where('user_id', auth()->user()->id)->first()->pivot->id);

                event(new UserSignedUpAsASub($sub));
            }
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
    public function update(Request $request, $cycle)
    {
        $cycle->load('weeks');

        // Update all weeks sent with request
        foreach($request->input('weeks') as $week){
            $week = $cycle->weeks->find($week);

            // check to see if user already has a deleted sub at this point.
            $sub = auth()->user()->subs()->withTrashed()->get()->whereIn('week_id', $week->id)->first();

            if ($sub) {
                if ($sub->trashed()) $sub->restore();
                $this->updateAllSubs(auth()->user(), $cycle, [
                    'div_pref_first' => $request->input('div_pref_first'),
                    'div_pref_second' => $request->input('div_pref_second'),
                    'note' => $request->input('note'),
                    'payment_method' => $request->input('payment_method')
                ]);
                $sub->refresh();
            } else {
                $week->subs()->attach(auth()->user()->id, [
                    'div_pref_first' => $request->input('div_pref_first'),
                    'div_pref_second' => $request->input('div_pref_second'),
                    'note' => $request->input('note'),
                    'payment_method' => $request->input('payment_method')
                ]);

                $sub = Sub::findOrFail($week->subs()->where('user_id', auth()->user()->id)->first()->pivot->id);
            }

            event(new UserUpdatedSubSignup(auth()->user(), $week, $sub));
        }

        // If the user removes a week, then we need to delete that week
        // For each week in the cycle, see if it is in the request
        // weeks. If it is not, then we need to see if the user
        // is signed up as a sub for that week and delete it.
        foreach($cycle->weeks as $week) {
            $found = in_array($week->id, $request->input('weeks'));
            $sub = null;
            if (!$found) $sub = Sub::where('user_id', auth()->user()->id)->where('week_id', $week->id)->first();

            if ($sub) $sub->delete();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $cycle)
    {
        $user = auth()->user();

        $weeksSubbing = auth()->user()->subs->whereIn('week_id', $cycle->weeks->pluck('id'));

        foreach($weeksSubbing as $week) {
            $week->delete();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    private function updateAllSubs($user, $cycle, $payload)
    {
        $weeksSubbing = auth()->user()->subs()->withTrashed()->get()->whereIn('week_id', $cycle->weeks->pluck('id'));

        foreach($weeksSubbing as $sub) {
            $sub->update($payload);
        }
    }
}
