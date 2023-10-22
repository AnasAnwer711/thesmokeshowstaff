<?php

namespace App\Http\Requests;

class SubscriptionPlanRequest extends Request
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
            'title' => 'required|string|max:191',
            // 'description' => 'required|string|max:191',
            'additional_note' => 'string|max:191',
            'duration_period' => 'required|string|max:191',
            'duration_number' => 'required|numeric|max:30',
            'amount' => 'required|numeric',
            'limit' => 'required|numeric',
            'status' => 'required|string|in:active,inactive',
        ];
    }
}
