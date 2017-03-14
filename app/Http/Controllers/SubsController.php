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
use Former;

class SubsController extends Controller
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
        $cycle->load('weeks', 'signups', 'weeks.subs');

        if ( !empty( $cycle->signups()->find($user->id) ) ){
            flash()->warning('You can not sign up as a sub because you are already signed up for this cycle.');
            return redirect()->route('cycles.view', $cycle->id);
        }

        return view('subs.create')
            ->withCycle($cycle)
            ->withUser($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // return $request->all();
        $cycle = Cycle::findOrFail($id);
        $cycle->load('weeks');

        $week = $cycle->weeks->find($request->input('week'));

        $week->subs()->attach(auth()->user()->id, ['note'=>$request->input('note')]);

        $sub = Sub::findOrFail($week->subs()->where('user_id', auth()->user()->id)->first()->pivot->id);

        event(new UserSignedUpAsASub($sub));

        flash()->success('You are signed up to sub!');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditSubSignupFormRequest $request, $id)
    {
        $sub = Sub::findOrFail($id);
        $sub->load('user', 'week');
        $user = $sub->user;

        $cycle = $sub->week->cycle;
        $cycle->load('weeks', 'signups', 'weeks.subs');

        if ( !empty( $cycle->signups()->find($user->id) ) ){
            flash()->warning('You can not sign up as a sub because you are already signed up for this cycle.');
            return redirect()->route('cycles.view', $cycle->id);
        }

        Former::populate($sub);
        return view('subs.edit')
            ->withCycle($cycle)
            ->withUser($user)
            ->withSub($sub);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubSignupRequest $request, $id)
    {
        $sub = Sub::findOrFail($id);
        $sub->load('user', 'week');
        $user = $sub->user;

        $cycle = $sub->week->cycle;
        $cycle->load('weeks', 'signups', 'weeks.subs');

        $week = $cycle->weeks->find($request->input('week'));

        $sub->week()->associate($week);
        $sub->note = $request->input('note');

        $sub->save();
        // $week->subs()->attach(auth()->user()->id, ['note'=>$request->input('note')]);

        event(new UserUpdatedSubSignup(auth()->user(), $week, $sub));

        if (auth()->user()->isAdmin()) {
            flash()->success('<a href="'.route('sub.edit', $sub->id).'"">Sub signup for ' . $user->name . '</a> has been updated.');

            return redirect()->route('users.show', $user->id);
        }

        flash()->success('Your sub signup has been updated.');

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
        $sub = Sub::findOrFail($id);

        $sub->delete();

        flash()->success('Sub sign-up deleted');

        return redirect()->route('users.dashboard');
    }

    /**
     * Show the team placement form for a sub
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamPlacementForm(Request $request, $id)
    {
        $sub = Sub::findOrFail($id);
        $sub->load('user', 'week');
        $data['sub']=$sub;
        $data['cycle']=$sub->week->cycle;
        $data['user']=$sub->user;
        $data['edit']=false;
        if ($request->isMethod('patch')) {
            $data['edit']=true;
        }
        $data['cycle_teams']=$data['cycle']->teams;

        return view('subs.teamPlacementForm', $data);
    }

    /**
     * Place a sub on a team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function placeOnATeam(SubTeamPlacementRequest $request, $id)
    {
        $sub = Sub::findOrFail($id);
        $sub->load('user');
        $team = Team::findOrFail($request->input('team_id'));
        $sub->team()->associate($team);
        $sub->save();
        $sub->load('team');
        // fire off event

        // See if there is a deleted transaction and undelete it
        $deletedTransaction = Transaction::onlyTrashed()
            ->where('cycle_id', $sub->week->cycle->id)
                    ->where('week_id', $sub->week_id)
                    ->where('user_id', $sub->user_id)
                    ->where('type', 'charge')->first();

        $transaction = Transaction::where('cycle_id', $sub->week->cycle->id)
            ->where('week_id', $sub->week_id)
            ->where('user_id', $sub->user_id)
            ->where('type', 'charge')->first();

        if($deletedTransaction && empty($transaction)) {
            $deletedTransaction->restore();
        } elseif (empty($transaction)) {
            Transaction::create([
                'cycle_id' => $sub->week->cycle->id,
                'week_id' => $sub->week_id,
                'user_id' => $sub->user_id,
                'type' => 'charge',
                'description' => 'Sub fee',
                'created_by' => auth()->user()->id,
                'date' => $sub->week->starts_at->format('Y-m-d'),
                'amount' => config('focus_cost.cycle.sub')
            ]);
        }
        flash()->success($sub->user->getNicknameOrShortName() . ' placed on Team ' . ucwords($sub->team->name) . ' as a sub.');
        return redirect()->back();
    }

    /**
     * Remove a sub from a team
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFromTeam(Request $request, $id)
    {
        $sub = Sub::findOrFail($id);
        $sub->load('user', 'team');
        $team = $sub->team;
        $sub->team()->dissociate();
        $sub->save();

        // fire off event

        $transaction = Transaction::where('cycle_id', $sub->week->cycle->id)
                    ->where('week_id', $sub->week_id)
                    ->where('user_id', $sub->user_id)
                    ->where('type', 'charge')
                    ->first();

        if($transaction) {
            $transaction->delete();
        }

        flash()->success($sub->user->getNicknameOrShortName() . ' removed from Team ' . ucwords($team->name) . ' as a sub.');

        return redirect()->back();
    }


    /**
     * Email sub announcement
     *
     * @param  int  $cycleId
     * @return \Illuminate\Http\Response
     */
    public function announce($weekId)
    {
        $cycleMailer = new Mailers\CycleMailer;
        $userMailer = new Mailers\UserMailer;
        $week = Week::findOrFail($weekId);

        $cycleMailer->sendSubTeamAnnouncementEmail($week);

        foreach($week->subs as $subUser) {
            if(is_null($subUser->pivot->team_id)) continue;
            $sub = Sub::findOrFail($subUser->pivot->id);
            $userMailer ->sendSubSpotConfirmationEmail($sub);
        }

        flash()->success('Sub announcment has been mailed to Subs and Captains.');

        return redirect()->route('admin.dashboard');
    }
}
