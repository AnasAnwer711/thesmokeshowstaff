<?php

namespace App\Http\Requests;

class CancellationPolicyRequest extends Request
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
            'user_type' => 'string|in:host,staff|required',
            'days' => 'integer|max:30|sometimes',
            'hours' => 'integer|max:24|sometimes',
            'charges' => 'numeric|max:999|required',
            'rule_type' => 'string|in:cancel,no-show|required',
            'transaction_type' => 'string|in:flat,percentage|required',
        ];
    }
}
