<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->id === (int) $this->route('id');
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
            'nickname'                      => 'min:3|unique:users,nickname,'.$this->route('id'),
            'gender'                        => 'required|in:male,female',
            'birthday'                      => 'required|date',
            'cell_number'                   => 'required|phone:LENIENT,US',
            'dominant_hand'                 => 'required|in:left,right',
            'height'                        => 'required|min:48|max:84|numeric',
            'division_preference_first'     => 'required|in:mens,mixed,womens',
            'password'                      => 'confirmed|min:8'
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
