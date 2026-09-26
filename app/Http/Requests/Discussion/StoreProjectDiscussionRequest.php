<?php

namespace App\Http\Requests\Discussion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectDiscussionRequest extends FormRequest
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
            'message' => 'nullable|string|required_without:file|max:255',
            'file'    => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,zip|required_without:message',
        ];

    }
}
