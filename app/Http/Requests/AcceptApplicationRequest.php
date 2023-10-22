<?php

namespace App\Http\Requests;

class AcceptApplicationRequest extends Request
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
        $rules = [
            'subscription_type'  => 'required',
            'card_id'  => 'required_if:subscription_type,==,card',
        ];
        return $rules;
    }
}
