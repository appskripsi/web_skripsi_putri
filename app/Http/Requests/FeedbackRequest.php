<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FeedbackRequest extends FormRequest
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
            'student_id' => [
                'nullable',
                'integer',
                'exists:tbl_mahasiswa,id'
            ],
            'deskripsi' => [
                'required',
                'string',
                'min:10'
            ]
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'student_id' => Auth::guard('student')->user()->id,
        ]);
    }
}