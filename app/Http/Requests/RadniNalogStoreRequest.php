<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RadniNalogStoreRequest extends FormRequest
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
            'domacinstvo_id' => ['required', 'integer'],
            'vozac_id' => ['required', 'integer'],
            'tehnolog_id' => ['required', 'integer'],
            'tipovi_mleka' => ['required', 'array', 'in_array_keys:kravlje,kozije,ovcije'],
        ];
    }
}
