<?php

namespace App\Http\Requests;

class JobRequest extends Request
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
        // dd($this['address']);
        $rules = [
            'title'  => 'required',
            'staff_category_id'  => 'required',
            'date'  => 'required',
            'description'  => 'required',
            'gender'  => 'required',
            'location'  => 'required',
            'start_time' => 'required',
            'duration' => 'required',
            'end_time' => 'required',
            'dress_code' => 'required',
            'job_title' => 'required',
            'pay_rate' => 'required',
            'pay_type' => 'required',
            'travel_allowance_id' => 'nullable',
            'no_of_positions' => 'required',
            'address.address_line1' => 'required',
            'address.suburb' => 'required',
            'address.state_id' => 'required',
            'address.postal_code' => 'required',
            'address.latitude' => 'required',
            'address.longitude' => 'required',
        ];
        
        return $rules;
    }
}
