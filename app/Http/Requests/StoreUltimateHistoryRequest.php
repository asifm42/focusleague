<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUltimateHistoryRequest extends Request
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
            'club_affiliation'          => 'required',
            'years_played'              => 'required',
            'summary'                   => 'required',
            'fav_defensive_position'    => 'required',
            'fav_offensive_position'    => 'required',
            'def_or_off'                => 'required',
            'best_skill'                => 'required',
            'skill_to_improve'          => 'required',
            'best_throw'                => 'required',
            'throw_to_improve'          => 'required',
        ];
    }
}
