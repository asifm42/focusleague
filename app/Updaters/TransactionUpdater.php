<?php
namespace App\Updaters;

use App\Events\TransactionUpdated;
use App\Contracts\Updater;
use App\Exceptions\SaveModelException;
use App\Models\Transaction;
use Hash;

class TransactionUpdater extends AbstractUpdater implements Updater
{
    /**
     * The Transaction instance
     *
     * @return void
     */
    // protected $user;

    /**
     * Create a new instance of the TransactionUpdater
     *
     * @return void
     */
    public function __construct()
    {
        //parent::__constuct();
    }

    /**
     * Update the Transaction entity
     *
     * @param array $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        // Get the transaction model
        $transaction = Transaction::findOrFail($id);

        // Update the transaction
        $transaction->fill($data);

        // Save a list of the changed attributes
        $changed = $transaction->getDirty();

        // Save the model. Throw an exception if error.
        if (! $transaction->save() ){
            throw new SaveModelException($transaction);
        }

        // Fire TransactionUpdated event
        event(new TransactionUpdated($transaction, $changed));

        return $transaction;
    }

}