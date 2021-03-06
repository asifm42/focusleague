<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Sub;

class EditSubSignupFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        $sub = Sub::findOrFail($this->route('id'));
        if(auth()->user()->id === $sub->user_id){
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
