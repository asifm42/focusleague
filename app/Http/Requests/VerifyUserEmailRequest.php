<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Flash;

class VerifyUserEmailRequest extends Request
{
    /**
     * The route to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'users.resetVerificationCodeForm';

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
            'confirmation_code' => 'required|size:32|exists:users'
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
            'confirmation_code.exists' => 'Your confirmation code has expired or is incorrect. Please request a new one to be sent.'
        ];
    }

}
