<?php

namespace App\Http\Requests;

class UserReviewRequest extends Request
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
            'comments.required_unless' => 'The comments field is required when rating is less than 3',
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
        return [
            'rating' => 'required|numeric',
            'source_id' => 'required|numeric',
            'target_id' => 'required|numeric',
            'job_id' => 'required|numeric',
            'comments' => 'required_unless:rating,3,4,5',
        ];
    }
}
