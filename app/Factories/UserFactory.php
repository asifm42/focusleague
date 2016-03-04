<?php
namespace App\Factories;

use App\Contracts\Factory;
use App\Events\UserRegistered;
use App\Exceptions\SaveModelException;
use App\Models\User;
use Hash;

class UserFactory extends AbstractFactory implements Factory
{
    /**
     * Create a new instance of the UserFactory
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__constuct();
    }

    /**
     * Make a new user entity
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function make(array $data)
    {
        $user = new User($data);

        // Manually add the non-fillable attributes
        $user['email']                  = $data['email'];
        $user['password']               = Hash::make($data['password']);
        $user['confirmation_code']      = str_random(32);
        // $user['promotion_code']         = $data['promotion'];

        if (! $user->save() ){
            throw new SaveModelException($user);
        }

        event(new UserRegistered($user));

        return $user;
    }

}