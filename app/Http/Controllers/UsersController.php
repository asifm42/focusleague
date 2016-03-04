<?php

namespace App\Http\Controllers;

use App\Factories\UserFactory;
use App\Http\Requests;
use App\Http\Requests\UserEditFormRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\VerificationCodeResetRequest;
use App\Http\Requests\VerifyUserEmailRequest;
use App\Http\Controllers\Controller;
use App\Jobs\ResetVerificationCode;
use App\Jobs\VerifyUser;
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

        return redirect()->back();
    }

    protected function verify(VerifyUserEmailRequest $request)
    {
        $this->dispatch(new VerifyUser($request->input('confirmation_code')));

        flash()->success('You have successfully verified your account.');

        return redirect('signin');
    }

    protected function resetVerificationCodeForm(Request $request)
    {
        if($request->input('error') == 'UnverifiedAccount') {
            flash()->error('Your email address has not been verified. Please verify your account by clicking the verification link in the welcome email.');
        }

        return view('auth.user.verify');
    }

    protected function resetVerificationCode(VerificationCodeResetRequest $request)
    {
        $this->dispatch(new ResetVerificationCode($request->input('email')));

        flash()->success('Welcome email resent! Please verify your account by clicking the verification link in the welcome email.');

        return redirect('signin');
    }
}
