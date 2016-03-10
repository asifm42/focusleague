<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\UltimateHistory;
use App\Models\User;
use App\Http\Requests\StoreUltimateHistoryRequest;
use App\Exceptions\SaveModelException;
use Former;

class UltimateHistoryController extends Controller
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
    public function create()
    {
        if (auth()->user()->ultimateHistory) {
            return redirect()->route('users.ultimate_history.edit', auth()->user()->id);
        } else {
            return view('ultimate_history.create')->withUser(auth()->user());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUltimateHistoryRequest $request, $id)
    {
        $history = new UltimateHistory;
        $history->fill($request->all());

        auth()->user()->ultimateHistory()->save($history);

        return redirect()->route('users.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $history = $user->ultimateHistory;
        if ($user->can('view', $history)) {
            return 'coming soon';
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Former::populate(auth()->user()->ultimateHistory);
        return view('ultimate_history.edit')->withUser(auth()->user());
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
        $user = User::findOrFail($id);
        $history = $user->ultimateHistory;
        $history->fill($request->all());

        // Save the model. Throw an exception if error.
        if (! $history->save() ){
            throw new SaveModelException($history);
        }

        flash()->success('Ultimate history updated');

        return redirect()->route('users.dashboard');
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
