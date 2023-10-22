<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class Request extends FormRequest
{
    public function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            response()->json(['success' => false, 'message' => $validator->errors()->first()], 422)
        );
    }
}