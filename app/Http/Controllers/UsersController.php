<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Http\Requests;
use App\Http\Requests\UserStoreRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
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
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $user = auth()->user();
        $data['user'] = $user;
        // $data['invoices'] = $user->invoices();
        // $data['upcomingInvoice'] = $user->upcomingInvoice();

        // set up the navigation options
        // $data['navigation_select'] = [
        //     '#profile'          => 'Profile',
        //     '#storage'          => 'Storage'
        // ];

        // add tags if needed
        // if ($user->onFreeTrial()
        //     || $user->onPaidPlan()
        //     || $user->isAdmin()
        //     || $user->isDev()) {
        //     $data['navigation_select']['#tags'] = 'Tags';
        // }

        return view('users.profile', $data );
    }
}
