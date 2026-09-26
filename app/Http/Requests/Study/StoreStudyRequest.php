<?php

namespace App\Http\Requests\Study;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudyRequest extends FormRequest
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
            'technical_solution'      => 'required|string',
            'scope_of_work'           => 'required|string',
            'estimated_duration_days' => 'required|integer|min:1',
            'estimated_cost'          => 'nullable|numeric|min:0',
            'technical_notes'         => 'nullable|string',
        ];
    }
}
