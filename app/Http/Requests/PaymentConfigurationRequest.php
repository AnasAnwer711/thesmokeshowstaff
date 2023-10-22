<?php

namespace App\Http\Requests;

class PaymentConfigurationRequest extends Request
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
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'currency_id.required' => 'Please select at least one currency',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'publishable_key' => 'required',
            'secret_key' => 'required',
            'currency_id' => 'required',
            'staff_transaction_type' => 'required',
            'staff_transaction_fee' => 'required',
            'host_transaction_type' => 'required',
            'host_transaction_fee' => 'required',
            
        ];
    }
}
