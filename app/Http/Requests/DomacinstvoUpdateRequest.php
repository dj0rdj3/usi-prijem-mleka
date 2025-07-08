<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomacinstvoUpdateRequest extends FormRequest
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
            'naziv' => ['required', 'string', 'max:255'],
            'adresa' => ['required', 'string', 'max:255'],
            'koordinate' => ['required', 'array', 'min:2', 'max:2'],
            'tipovi_mleka' => ['required', 'array', 'min:1', 'max:3'],
            'tipovi_mleka.*' => ['in:kravlje,kozije,ovcije']
        ];
    }
}
