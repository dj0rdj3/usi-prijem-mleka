<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RadniNalogUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'kolicina_mleka' => ['nullable', 'integer'],
            'procenat_mm' => ['nullable', 'numeric', 'between:0.0,99.9'],
            'primljeno' => ['nullable', 'boolean'],
            'komentar' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
