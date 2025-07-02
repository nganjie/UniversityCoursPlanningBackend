<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterEtudiantRequest extends FormRequest
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
            "registration_number" => ["required", "string", "max:255"],
            "first_name" => ["required", "string", "max:255"],
            "last_name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", "unique:etudiants,email"],
            "password" => ["required", "string", "min:8", "confirmed"],
            "password_confirmation" => ["required", "string", "min:8", "same:password"],
            "phone"=>["required", "string","max:15", "unique:etudiants,phone"],
            "gender" => ["required", new Enum(GenderEnum::class)],
            "etablissement_id" => ["required", "exists:etablissements,id"],

        ];
    }
}
