<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nim' => [
                'required',
                'string',
                'max:20',
                'unique:tbl_mahasiswa,nim'
            ],
            'name' => [
                'required',
                'string',
                'max:100'
            ],
            'gender' => [
                'required',
                'string',
                'in:L,PS'
            ],
            'password' => [
                'required',
                'string',
                'max:255',
                'min:8'
            ],
            'academic_id' => [
                'required',
                'integer',
                'exists:tbl_program_studi,id'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'academic_id' => 'academic',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'name' => ucwords($this->name)
        ]);
    }
}
