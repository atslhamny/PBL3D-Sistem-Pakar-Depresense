<?php

namespace App\Http\Requests\Screening;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveAnswerRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_number' => 'required|integer|min:1|max:21',
            'question_id' => 'required|exists:bdi_questions,id',
            'answer_value' => 'required|integer|min:0|max:3',
        ];
    }
}
