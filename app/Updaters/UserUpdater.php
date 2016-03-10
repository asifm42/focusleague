<?php
namespace App\Updaters;

use App\Events\UserUpdated;
use App\Contracts\Updater;
use App\Exceptions\SaveModelException;
use App\Models\User;
use Hash;

class UserUpdater extends AbstractUpdater implements Updater
{
    /**
     * The user instance
     *
     * @return void
     */
    // protected $user;

    /**
     * Create a new instance of the UserUpdater
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__constuct();
    }

    /**
     * Update the user entity
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        // Get the user model
        $user = User::findOrFail($id);

        // Update the user
        $user->fill($data);

        // Update password if provided
        if(! empty($data['password']))
            $user['password'] = Hash::make($data['password']);

        // Save a list of the changed attributes
        $changed = $user->getDirty();

        // Save the model. Throw an exception if error.
        if (! $user->save() ){
            throw new SaveModelException($user);
        }

        // Fire UserUpdated event
        event(new UserUpdated($user, $changed));

        return $user;
    }

}