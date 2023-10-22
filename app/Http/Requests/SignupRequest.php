<?php

namespace App\Http\Requests;

class SignupRequest extends Request
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
            'gender.required_if' => 'The gender field is required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name'  => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'  => 'required|string|min:11',
            'gender'  => 'required_if:type,==,staff',
            'display_name'  => 'sometimes|string|max:50',
            'email'  => 'required|email|unique:users',
            'password'  => 'required|min:8',
            'type'  => 'required|in:host,staff',
        ];
        return $rules;
    }
}