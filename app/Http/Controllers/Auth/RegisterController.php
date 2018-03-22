<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RegistersUsers;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'              => 'required|max:255',
            'email'             => 'required|email|max:255|unique:users',
            'nickname'          => 'nullable|unique:users,nickname|min:3|max:15',
            'gender'            => 'required|in:male,female',
            'birthday'          => 'required|date',
            'cell_number'       => 'required|phone:LENIENT,US',
            'dominant_hand'     => 'required|in:left,right',
            'height'            => 'required|min:48|max:84|numeric',
            'division_preference_first'     => 'required|in:mens,mixed,womens',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $data['birthday'] =  Carbon::createFromFormat('Y-m-d', $data['birthday']);

        $user = new User($data);

        // Manually add the non-fillable attributes
        $user['email']                  = $data['email'];
        $user['password']               = bcrypt($data['password']);
        $user['confirmation_code']      = str_random(32);

        if (! $user->save() ){
            throw new SaveModelException($user);
        }

        return $user;
    }
}