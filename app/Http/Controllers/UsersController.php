<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Http\Requests;
use App\Http\Requests\UserEditFormRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Cycle;
use App\Models\User;
use App\Updaters\UserUpdater;
use Illuminate\Http\Request;
use Former;

class UsersController extends Controller
{
    public function __construct(UserFactory $userFactory, UserUpdater $userUpdater)
    {
        $this->userFactory = $userFactory;
        $this->userUpdater = $userUpdater;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = $users = User::all();

        return view('users.index', $data);
    }

    /**
     * Display a listing of the users who have a positive balance.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDelinquentUsers()
    {
        $users = User::all();

        $data['users'] = $users->filter(function ($item) {
            return $item->getBalance() > 0;
        });

        return view('users.index', $data);
    }

    /**
     * Show the create form
     *
     * @return View
     */
    public function create(Request $request)
    {
        return view('users.create');
    }


    /**
     * Save the user's profile information.
     *
     * @return Redirect
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->userFactory->make($request->all());

        $user->ip_address = $request->ip();

        if (! $user->save() ){
            throw new SaveModelException($user);
        }

        flash()->success('Your account has been created. Please verify your account by clicking the verification link in the welcome email.');

        return redirect('signin');
    }

    /**
     * Show the user's dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $user->load('ultimateHistory');
        $data['user'] = $user;
        $data['current_cycle'] = Cycle::current_cycle();
        $data['next_cycle'] = Cycle::next_cycle();
        $data['current_cycle_sub_weeks'] = [];
        $data['next_cycle_sub_weeks'] = [];
        $data['balance'] = number_format($user->getBalance(), 2, '.', ',');
        if ($data['current_cycle']) {
            $data['current_cycle_signup'] = $user->current_cycle_signup();

            foreach($data['current_cycle']->weeks as $week){
                $sub_deets = $week->subs->find($user->id);
                if ($sub_deets){
                    $data['current_cycle_sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
                }
            }
        } else {
            $data['current_cycle_signup'] = [];
        }
        if ($data['next_cycle']) {
            $data['next_cycle_signup'] = $user->cycles()->where('cycle_id', $data['next_cycle']->id)->first();
            foreach($data['next_cycle']->weeks as $week){
                $sub_deets = $week->subs->find($user->id);
                if ($sub_deets){
                    $data['next_cycle_sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
                }
            }
        } else {
            $data['next_cycle_signup'] = [];
        }

        return view('users.dashboard', $data );
    }

    /**
     * Show the user's dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->load('ultimateHistory');
        // dd($user->availability()->where('cycle_id',2)->get());
        $data['user'] = $user;
        $data['current_cycle'] = Cycle::current_cycle();
        $data['next_cycle'] = Cycle::next_cycle();
        $data['current_cycle_sub_weeks'] = [];
        $data['next_cycle_sub_weeks'] = [];
        $data['balance'] = $user->getBalance();
        if ($data['current_cycle']) {
            $data['current_cycle_signup'] = $user->current_cycle_signup();

            foreach($data['current_cycle']->weeks as $week){
                $sub_deets = $week->subs->find($user->id);
                if ($sub_deets){
                    $data['current_cycle_sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
                }
            }
        } else {
            $data['current_cycle_signup'] = [];
        }
        if ($data['next_cycle']) {
            $data['next_cycle_signup'] = $user->cycles()->where('cycle_id', $data['next_cycle']->id)->first();
            foreach($data['next_cycle']->weeks as $week){
                $sub_deets = $week->subs->find($user->id);
                if ($sub_deets){
                    $data['next_cycle_sub_weeks'][] = ['week'=>$week,'deets'=>$sub_deets];
                }
            }
        } else {
            $data['next_cycle_signup'] = [];
        }

        return view('users.dashboard', $data );
    }

    /**
     * Show the user's profile edit form.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(UserEditFormRequest $request) {
        $user = User::findOrFail($request->id);
        $data['user'] = $user;
        Former::populate($user);
        return view('users.edit', $data );
    }

    /**
     * Update the user's information
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userUpdater->update($id, $request->all());

        flash()->success('Update Saved');

        return redirect()->route('users.dashboard');
    }
}
