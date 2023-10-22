<?php

namespace App\Http\Requests;

class CreditCardRequest extends Request
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
        // dd($this->all());
        $rules = [
            'name'  => 'required',
            'number'  => 'required',
            'expiry'  => 'required',
            'cvc'  => 'required',
        ];
        return $rules;
    }
}
