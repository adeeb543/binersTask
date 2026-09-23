<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // مسموح للـ authenticated user بالوصول (الـ Middleware يحمي الروت أساساً)
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,jpg,jpeg,png,zip'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'يرجى اختيار ملف لرفعه.',
            'file.file' => 'الملف المرسل غير صالح.',
            'file.max' => 'حجم الملف يجب ألا يتجاوز 10 ميجابايت.',
            'file.mimes' => 'صيغة الملف غير مدعومة. الصيغ المسموحة هي: pdf, doc, docx, jpg, jpeg, png, zip.',
        ];
    }
}
