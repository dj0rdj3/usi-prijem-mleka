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
                // ne dozvoljavamo unos polja ako korisnik nije vozac
                Rule::prohibitedIf(fn() => $this->user()->tip !== 'vozac'),
                // ne dozvoljavamo unos polja ako je polje komentar popunjeno
                Rule::prohibitedIf(fn() => !is_null($this->input('komentar'))),
                // obavezan unos polja ako je korisnik vozac i ako je polje komentar prazno
                Rule::requiredIf(fn() => $this->user()->tip === 'vozac' && is_null($this->input('komentar')))
            ],
            'procenat_mm' => [
                'nullable',
                'numeric',
                'between:0.0,99.9',
                // ne dozvoljavamo unos polja ako korisnik nije tehnolog
                Rule::prohibitedIf(fn() => $this->user()->tip !== 'tehnolog'),
                // obavezan unos polja ako je mleko primljeno
                Rule::requiredIf(fn() => $this->input('primljeno') === '1' || $this->input('primljeno') === 1)
            ],
            'primljeno' => [
                'nullable',
                'boolean',
                // ne dozvoljavamo unos polja ako korisnik nije tehnolog
                Rule::prohibitedIf(fn() => $this->user()->tip !== 'tehnolog'),
                // obavezan unosa polja ako je korisnik tehnolog
                Rule::requiredIf(fn() => $this->user()->tip === 'tehnolog')
            ],
            'komentar' => [
                'nullable',
                'string',
                'max:5000',
                // obavezan unos polja ako mleko nije primljeno
                Rule::requiredIf(fn() => $this->input('primljeno') === '0' || $this->input('primljeno') === 0)
            ],
        ];
    }
}
