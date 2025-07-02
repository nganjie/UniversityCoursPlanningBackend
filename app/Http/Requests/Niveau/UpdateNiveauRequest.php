<?php

namespace App\Http\Requests\Niveau;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNiveauRequest extends FormRequest
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
            "name" => ['string'],
            "code" => ['string'],
            // Additional rules can be added here if needed
        ];
    }
}
