<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterEnseignantRequest extends FormRequest
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
            'registration_number'=>['required','string'],
            'password'=>['required','string'],
        'first_name'=>['required','string'],
        'last_name'=>['required','string'],
        'gender'=>['required',new Enum(GenderEnum::class)],
        'email'=>['required','unique:enseignants,email'],
        'phone'=>['required','string'],
        ];
    }
}
