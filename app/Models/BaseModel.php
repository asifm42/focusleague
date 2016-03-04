<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;

class BaseModel extends Model
{
    use ValidatingTrait;
}
