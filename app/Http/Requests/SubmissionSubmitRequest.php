<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SubmissionSubmitRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        return redirect('/')->withErrors($validator->errors());
    }
}
