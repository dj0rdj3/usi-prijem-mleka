<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'kolicina_mleka' => [
                'nullable',
                'integer',
                Rule::prohibitedIf(fn() => !is_null($this->input('komentar'))),
                Rule::requiredIf(fn() => $this->user()->tip === 'vozac' && is_null($this->input('komentar')))
            ],
            'procenat_mm' => [
                'nullable',
                'numeric',
                'between:0.0,99.9',
                Rule::requiredIf(fn() => $this->input('primljeno') === '1')
            ],
            'primljeno' => [
                'nullable',
                'boolean',
                Rule::requiredIf(fn() => $this->user()->tip === 'tehnolog')
            ],
            'komentar' => [
                'nullable',
                'string',
                'max:5000',
                Rule::requiredIf(fn() => $this->input('primljeno') === '0')
            ],
        ];
    }
}
