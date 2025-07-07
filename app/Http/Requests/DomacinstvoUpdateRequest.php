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
            'adresa' => ['required', 'string', 'max:255'],
            'koordinate' => ['required', 'string', 'max:255'],
            'tipovi_mleka' => ['required', 'array', 'in_array_keys:kravlje,kozije,ovcije'],
        ];
    }
}
