<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Cycle;
use Artisan;

class CycleTeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if ($id === 'current') {
            $cycle = Cycle::current_cycle();
            if (!$cycle) {
                flash()->info('Sorry, there is no current cycle at the moment.');

                return redirect()->route('cycles.index');
            }
        } else {
            $cycle = Cycle::findOrFail($id);
        }

        $cycle->load('signups', 'weeks', 'weeks.subs', 'weeks.games', 'signups.availability', 'teams');

        $data['cycle'] = $cycle;

        if ($cycle->teams_published) {
            flash()->warning('<strong>Teams are published!</strong>');
        }

        return view('teams.builder', $data);
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

    /**
     * Publish the cycle's teams
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $cycle = Cycle::findOrFail($id);

        $cycle->teams_published = 1;

        $cycle->save();

        return redirect()->route('cycle.teams.builder', ['id' => $cycle->id]);
    }

    /**
     * Unpublish the cycle's teams
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unpublish($id)
    {
        $cycle = Cycle::findOrFail($id);

        $cycle->teams_published = 0;

        $cycle->save();

        return redirect()->route('cycle.teams.builder', ['id' => $cycle->id]);
    }

    /**
     * Email team announcement
     *
     * @param  int  $cycleId
     * @return \Illuminate\Http\Response
     */
    public function announce($id)
    {

        $exitCode = Artisan::call('charge:cyclePlayerFee', [
            'cycle' => $id
        ]);
        // only sends the email for the current cycle

        Artisan::queue('emails:sendTeamAnnouncementEmail');

        flash()->success('Team announcement has been emailed to all current cycle signups.');

        return redirect()->route('cycle.teams.builder', ['id' => 'current']);
    }
}
