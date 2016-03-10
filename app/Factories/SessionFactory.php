<?php

namespace App\Factories;

use App\Contracts\Factory;
use App\Factories\AbstractFactory;
use App\Exceptions\SaveModelException;
use App\Exceptions\UnverifiedAccountException;
// use App\Models\Session;

class SessionFactory extends AbstractFactory implements Factory
{
    /**
     * Create a new instance of the UserFactory
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Make a new session entity
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function make(array $data)
    {
        $session = [];

        $credentials['email']       =  $data['email'];
        $credentials['password']    =  $data['password'];

        $rememberMe = $data['rememberMe'];

        if (! auth()->attempt($credentials, $rememberMe)) {
            // user log in failed
            return false;
        }

        // Check if the user's email is confirmed.
        if (! auth()->user()->confirmed) {
            // Get a reference to the user
            $user = auth()->user();
            // Log the user out.
            auth()->logout();

            throw new UnverifiedAccountException($user);
        }

        // Log the request ip address and a timestamp for last_login
        $user = auth()->user();

        $user->ip_address = $data['ip_address'];
        $user->last_login = date('Y-m-d H:i:s', time());

        if (! $user->save() ){
            throw new SaveModelException($user);
        }

        $session['user'] = $user;

        return $session;

    }

    // public function getApiKey()
    // {
    //     if (auth()->check()) {

    //         // Assign an API key for this session
    //         $apiKey = ApiKey::where('user_id', '=', auth()->user()->id)->first();

    //         // if there isn't one, then create one, if there is, set a new one.
    //         if (! isset($apiKey)) {
    //             $apiKey = $this->apiKeyFactory->make(['userId'=>auth()->user()->id]);
    //         } else {
    //             $apiKey->generateKey();

    //             if (! $apiKey->save()) {
    //                 throw new SaveModelException($apiKey);
    //             }
    //         }

    //         //return the api_key
    //         return $apiKey;
    //     }

    //     return ("Fail");
    // }

}