<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SignInRequest extends Request
{
    /**
     * Message to be displayed if authorization fails
     *
    */
    protected $forbiddenMsg = 'You do not have permission to register an account.';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|max:255',
            'password'  => 'required'
        ];
    }
}
