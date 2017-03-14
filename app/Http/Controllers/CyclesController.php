<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Cycle;

class CyclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cycles'] = Cycle::all()->reverse();

        $data['current_cycle'] = Cycle::currentCycle();

        $data['next_cycle'] = Cycle::nextCycle();

        return view('cycles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Cycle $cycle)
    {
        $cycle->load('signups', 'weeks', 'weeks.subs', 'weeks.games', 'signups.availability', 'teams');

        $data['cycle'] = $cycle;
        $data['user'] = $user = auth()->user();
        $data['current_cycle_signup'] = $user->cycles->find($cycle->id);
        $data['sub_weeks'] = [];
        foreach($cycle->weeks as $week){
            $sub_deets = $week->subs->find($user->id);
            if ($sub_deets){
                $data['sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
            }
        }
        if ($cycle->areTeamsPublished()) {
            // $data['team1signups'] = $cycle->teams->find(1)->players;
            // dd($data['team1signups']->load('user'));
        } else {
            $data['current_cycle_signups'] = $cycle->signups()->get()->load('availability');

            $data['currentMaleSignups'] = $data['current_cycle_signups']->filter(function ($value, $key) {
                return strtolower($value->gender) == "male";
            });

            $data['currentFemaleSignups'] = $data['current_cycle_signups']->filter(function ($value, $key) {
                return strtolower($value->gender) == "female";
            });
        }

        return view('cycles.show', $data);
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

    /**
     * Get the resource in json style
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function apiGetJson(Cycle $cycle)
    {
        $cycle->load('signups', 'weeks', 'weeks.subs', 'weeks.games', 'signups.availability', 'teams', 'teams.captains', 'teams.captains.user');

        return  response()->json($cycle);
    }

}
