<?php

namespace App\Http\Requests;

class HelpfulKeyRequest extends Request
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
            'icon' => 'required|file',
            'description' => 'required|string|max:191',
        ];
    }
}
