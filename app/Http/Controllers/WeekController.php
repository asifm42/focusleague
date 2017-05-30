<?php

namespace App\Http\Controllers;

use App\Models\Week;
use App\Notifications\Rainout;
use Illuminate\Http\Request;

class WeekController extends Controller
{

    public function show(Request $request, $id)
    {
        $week = Week::findOrFail($id);

        return view('weeks.show')->withWeek($week);
    }

    public function rainout(Request $request, $id)
    {
        $week = Week::findOrFail($id);

        if (!$request->has('rained_out') || !$request->input('rained_out')) return;

        // mark as rainout
        $week->markAsRainedOut();

        // update status
        $week->updateStatus($request->input('status'));

        // apply rainout credits to players and subs
        $week->players()->each->applyRainoutCredit($week);
        $week->subsOnATeam->each->applyRainoutCredit($week);

        // send message to all players and subs
        $week->players()->each->notify(new Rainout($week));
        $week->subsOnATeam->each->notify(new Rainout($week));

        return redirect()->route('weeks.show', $week->id);
    }
}
