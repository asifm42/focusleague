<?php
namespace App\Exceptions;

use Illuminate\Database\Eloquent\Model;

class SaveModelException extends \Exception
{
    public $model;

    /**
     * Create the exception.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

}