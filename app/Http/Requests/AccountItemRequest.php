<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountItemRequest extends FormRequest
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
            'product_id' => 'required',
            'username' => 'required',
            'password' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'product_id.required' => 'Kolom nama produk wajib diisi.',
            'username.required' => 'Kolom nama akun wajib diisi.',
            'password.required' => 'Kolom kata sandi wajib diisi.'
        ];
    }
}
