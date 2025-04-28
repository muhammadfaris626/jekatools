<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'desc' => 'required',
            // 'duration_days' => 'nullable',
            // 'stock' => 'nullable',
            // 'thumbnail' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Kolom nama produk wajib diisi.',
            'type.required' => 'Kolom jenis produk wajib diisi.',
            'price.required' => 'Kolom harga produk wajib diisi.',
            'desc.required' => 'Kolom keterangan produk wajib diisi.',
            // 'thumbnail.required' => 'Kolom thumbnail wajib diisi.'
        ];
    }
}
