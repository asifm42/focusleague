<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserStoreRequest extends Request
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
            'name'                          => 'required|max:255',
            'email'                         => 'required|email',
            'gender'                        => 'required|in:male,female',
            'birthday'                      => 'required|date',
            'cell_number'                   => 'required|max:30|numeric',
            'dominant_hand'                 => 'required|in:left,right',
            'height'                        => 'required|min:48|max:84|numeric',
            'division_preference_first'     => 'required|in:mens,mixed,womens',
            'password'                      => 'required|confirmed|min:8'
        ];
    }
}
