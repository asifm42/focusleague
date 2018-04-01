<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CycleSignup;
use Illuminate\Http\Request;

class CycleSignupsTeamController extends Controller
{
    /**
     * Associate the signup with a team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CycleSignup $cyclesignup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CycleSignup $cyclesignup)
    {
        $cyclesignup->update([
            'team_id'    => $request->input('team_id'),
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Remove the signup from a team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CycleSignup $cyclesignup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CycleSignup $cyclesignup)
    {
        $cyclesignup->update([
            'team_id'    => null,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
