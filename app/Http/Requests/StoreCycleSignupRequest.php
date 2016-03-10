<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreCycleSignupRequest extends Request
{
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
            'div_pref_first'        => 'required|in:mens,mixed,womens,Mens,Mixed,Womens',
            'will_captain'          => 'required',
            'weeks'                 => 'array',
            'note'                  => 'max:500',
            // 'nickname'                      => 'unique:users,nickname|min:3',
            // 'gender'                        => 'required|in:male,female',
            // 'birthday'                      => 'required|date',
            // 'cell_number'                   => 'required|phone:LENIENT,US',
            // 'dominant_hand'                 => 'required|in:left,right',
            // 'height'                        => 'required|min:48|max:84|numeric',
            // 'password'                      => 'required|confirmed|min:8'
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
            //
        ];
    }
}
