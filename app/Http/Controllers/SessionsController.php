<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Factories\SessionFactory;
use Debugbar;

class SessionsController extends Controller
{
    protected $sessionFactory;

    public function __construct(SessionFactory $sessionFactory)
    {
        $this->sessionFactory = $sessionFactory;
    }

    /**
     * Show the Sign In Form.
     *
     * @return View
     */
    public function create(Request $request)
    {
        return view('auth.user.signIn');
    }

    public function signIn(SignInRequest $request)
    {
        $data = [];
        $data['email']          =  $request->get('email');
        $data['password']       =  $request->get('password');
        $data['rememberMe']     = (($request->get('remember_me') === 'true') ? true : false);
        $data['ip_address']     = $request->ip();

        $session = $this->sessionFactory->make($data);

        if ($session) {
            return redirect()->intended('profile');
        }

        // Set up error flash message
        flash()->error('<strong>Try again!</strong> Your email or password was incorrect.');

        // redirect to login form. Don't need to send validation errors.
        return redirect()->route('sessions.create')->withInput();
    }

    public function signOut()
    {
        if (! auth()->check()) {
            return redirect(route('sessions.signin'));
        }

        auth()->logout();

        // Set up success flash message
        flash()->success('<strong>Success!</strong> You have signed out. Have a nice day!');

        return redirect()->route('sessions.create');
    }
}
