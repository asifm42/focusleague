<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VerificationCodeResetRequest extends Request
{
    /**
     * Message to be displayed if authorization fails
     *
    */
    protected $forbiddenMsg = 'You do not have permission to reset this verification code.';

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
            'email'     => 'required|max:255|email|exists:users'
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'    => 'Email is required',
            'email.email'       => 'Email must be a valid email',
            'email.exists'      => 'Sorry, we can not find an account with this email',
        ];
    }

}
