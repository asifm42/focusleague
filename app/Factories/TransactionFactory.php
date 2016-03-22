<?php
namespace App\Factories;

use App\Contracts\Factory;
use App\Events\TransactionPosted;
use App\Exceptions\SaveModelException;
use App\Models\Transaction;
use Hash;

class TransactionFactory extends AbstractFactory implements Factory
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
        $transaction = new Transaction($data);

        if (! $transaction->save() ){
            throw new SaveModelException($transaction);
        }

        event(new TransactionPosted($transaction));

        return $transaction;
    }

}