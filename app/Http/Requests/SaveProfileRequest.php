<?php

namespace App\Http\Requests;

class SaveProfileRequest extends Request
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
            'address.suburb.required' => 'Suburb field is required',
            'address.postal_code.required' => 'Postal code field is required',
            'address.state_id.required' => 'State field is required',
            'nationality_id.required' => 'Nationality field is required',
            // 'build_type_id.required' => 'Build type field is required',
            'language_ids.required' => 'Language field is required',
        ];
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
            'first_name'  => 'required|string',
            'last_name'  => 'required|string',
            'phone'  => 'required|string',
            'email'  => 'required|email',
            // 'address' => 'required|array',
            'address.suburb' => 'required',
            'address.postal_code' => 'required',
            'address.state_id' => 'required',
        ];

        // dd($this->roles[0]);
        if($this->roles[0]['name'] == 'staff') {
            $rules['resume'] = 'required';
            $rules['nationality_id'] = 'required';
            $rules['language_ids'] = 'required';
            // $rules['build_type_id'] = 'required';
            // $rules['english_level'] = 'required';
        }
        return $rules;
    }
}