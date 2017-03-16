<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditTransactionRequest extends Request
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
            'user_id'           => 'required|integer',
            'cycle_id'          => 'integer',
            'week_id'           => 'integer',
            'type'              => 'required|in:charge,payment,credit',
            'payment_type'      => 'required_if:type,payment|in:paypal,venmo,chase quickpay,square cash,check,cash',
            'description'       => 'required|max:500',
            'amount'            => 'required|integer',
            'date'              => 'date',
        ];
    }
}
