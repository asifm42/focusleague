<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationCodeResetRequest;
use App\Jobs\ResetVerificationCode;
use App\Jobs\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function verifyEmail(Request $request, $confirmationCode)
    {
        $validator = Validator::make(['confirmation_code' => $confirmationCode], [
            'confirmation_code' => 'size:32|exists:users'
        ]);

        if ($validator->fails()) {
            flash()->error('Your confirmation code has expired or is incorrect. Please request a new one to be sent.');
            return redirect()->route('users.resetVerificationCodeForm');
        }

        $this->dispatch(new VerifyUser($confirmationCode));

        flash()->success('You have successfully verified your email address.');

        return redirect()->route('sessions.signin');
    }

    protected function resetVerificationCodeForm(Request $request)
    {
        if($request->input('error') == 'UnverifiedAccount')
            flash()->error('Your email address has not been verified. Please verify it by clicking the link in the verification email.');

        return view('auth.user.verify');
    }

    protected function resetVerificationCode(VerificationCodeResetRequest $request)
    {
        $this->dispatch(new ResetVerificationCode($request->input('email')));

        flash()->success('Verification email resent! Please verify your email address by clicking the link in the verification email.');

        return redirect()->route('sessions.signin');
    }

}
