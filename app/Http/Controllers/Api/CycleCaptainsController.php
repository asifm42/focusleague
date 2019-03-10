<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\CycleSignup;
use Illuminate\Http\Request;

class CycleCaptainsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cyclesignup)
    {
        $cyclesignup->load('user');
        $user = $cyclesignup->user;

        if ($cyclesignup->trashed()) $cyclesignup->restore();

        $cyclesignup->update([
            'captain'      => $request->input('captain'),
        ]);


        return response()->json([
            'status' => 'success'
        ]);
    }
}
