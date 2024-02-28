<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ApiSubmissionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:256'],
            'questions' => ['required', 'array'],
            'questions.*.id' => ['required', 'numeric', 'max:100', 'exists:questions,id'],
            'questions.*.answer' => ['required', 'numeric', 'max:100', 'exists:weights,id'],
        ];
    }

    protected function failedAuthorization()
    {
        throw new HttpResponseException(response()->json([
            'errors' => 'Unauthorized.'
        ], Response::HTTP_UNAUTHORIZED));
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->getMessageBag(),
        ], Response::HTTP_BAD_REQUEST));
    }
}
