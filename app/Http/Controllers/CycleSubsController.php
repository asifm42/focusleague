<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\EditSubSignupFormRequest;
use App\Http\Requests\UpdateSubSignupRequest;
use App\Http\Requests\SubTeamPlacementRequest;
use App\Mailers;
use App\Models\Cycle;
use App\Models\Sub;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\Week;
use App\Events\UserSignedUpAsASub;
use App\Events\UserUpdatedSubSignup;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        // if ($id === 'current') {
        //     $cycle = Cycle::currentCycle();
        //     if (!$cycle) {
        //         flash()->info('Sorry, there is no current cycle at the moment.');

        //         return redirect()->route('cycles.index');
        //     }
        // } else {
        //     $cycle = Cycle::findOrFail($id);
        // }
        // $user = auth()->user();
        // $cycle->load('weeks', 'signups', 'weeks.subs');

        // if ( !empty( $cycle->signups()->find($user->id) ) ){
        //     flash()->warning('You can not sign up as a sub because you are already signed up for this cycle.');
        //     return redirect()->route('cycles.view', $cycle->id);
        // }

        // return view('subs.create')
        //     ->withCycle($cycle)
        //     ->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $cycle)
    {
        $user = auth()->user();

        // If user already has a player signup redirect to edit form
        if ($user->cycles()->find($cycle->id)) {
            return redirect()->route('cycle.signup.edit', $cycle->id);
        }

        $weeksSubbing = $user->subs->whereIn('week_id', $cycle->weeks->pluck('id'));

        if (count($weeksSubbing) == 0) {
            flash('You aren\'t signed up as a sub to play that cycle')->error();

            return redirect()->back();
        }

        $weeksSubbing->load('week.cycle', 'user');
        $cycle->load('weeks');

        $sub = $weeksSubbing->first();

        // $subOriginal = [
        //     'div_pref_first' => $sub->div_pref_first,
        //     'div_pref_second' => $sub->div_pref_second,
        //     'payment_method' => $sub->payment_method,
        //     'note' => $sub->note
        // ];

        // if ( auth()->user()->cannot('update', $signup) ) {
        //     throw new UnauthorizedAccessException;
        // }

        return view('cycles.signups.edit')
                ->withCycle($cycle)
                ->withUser($user)
                ->withWeeksSubbing($weeksSubbing)
                ->withCost(config('focus.cost'));
    }
}
