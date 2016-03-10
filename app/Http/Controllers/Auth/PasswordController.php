<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;


// use App\Http\Requests\ResetPasswordRequest;
use App\Factories\SessionFactory;

// use Illuminate\Http\Request;
// use Illuminate\Mail\Message;
// use Password;
// use Flash;


class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/dashboard';
    protected $sessionFactory;
    protected $linkRequestView = 'auth.passwords.forgotPassword';
    protected $resetView = 'auth.passwords.reset';


    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(SessionFactory $sessionFactory)
    {
        $this->middleware('guest');
        $this->sessionFactory = $sessionFactory;
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     * Overriding to insert Flash message
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        flash()->success(trans($response));
        return redirect()->back()->with('status', trans($response));
    }

    /**
     * Get the response for after the reset link could not be sent.
     * Overriding to insert Flash message
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getSendResetLinkEmailFailureResponse($response)
    {
        flash()->error(trans($response));
        return redirect()->back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the response for after a successful password reset.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetSuccessResponse($response)
    {
        flash()->success(trans($response));
        // return redirect($this->redirectPath())->with('status', trans($response));
        return redirect(route('sessions.create'));
    }

    /**
     * Get the response for after a failing password reset.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetFailureResponse(Request $request, $response)
    {
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        $user->save();

        // Don't log in the user here. We will use session factory in the getResetSuccessResponse method.
        // Auth::guard($this->getGuard())->login($user);
    }
}
