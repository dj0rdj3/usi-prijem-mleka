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
            'domacinstvo_id' => ['required', 'integer', 'exists:domacinstva,id'],
            'vozac_id' => ['required', 'integer', 'exists:users,id'],
            'tehnolog_id' => ['required', 'integer', 'exists:users,id'],
            'tip_mleka' => ['required', 'string', 'in:kravlje,kozije,ovcije'],
        ];
    }
}
