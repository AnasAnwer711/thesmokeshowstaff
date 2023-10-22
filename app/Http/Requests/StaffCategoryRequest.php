<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffCategoryRequest extends Request
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
            "title" => "required|string|max:191",
            "description" => "nullable|string|max:191",
            "category_id" => "nullable|integer",
            "is_active" => "nullable|boolean",
            "gender" => "nullable|string",
            "min_rate" => "sometimes|numeric",
            "helpful_key_id" => "required_if:category_id,!=,null"
        ];
    }
}
