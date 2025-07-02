<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateEnseignantRequest extends FormRequest
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
            'registration_number'=>['string'],
            'password'=>['string'],
        'first_name'=>['string'],
        'last_name'=>['string'],
        'gender'=>[new Enum(type: GenderEnum::class)],
        'email'=>['exists:enseignants,email'],
        'phone'=>['string'],
        ];
    }
}
