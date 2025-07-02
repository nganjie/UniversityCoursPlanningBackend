<?php

namespace App\Http\Requests\Etudiant;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateEtudiantRequest extends FormRequest
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
            "registration_number" => [ "string", "max:255"],
            "first_name" => [ "string", "max:255"],
            "last_name" => [ "string", "max:255"],
            "email" => [ "string", "email", "max:255", "unique:etudiants,email"],
            "password" => [ "string", "min:8", "confirmed"],
            "password_confirmation" => [ "string", "min:8", "same:password"],
            "phone"=>[ "string","max:15", "unique:etudiants,phone"],
            "gender" => [ new Enum(GenderEnum::class)],
            "etablissement_id" => [ "exists:etablissements,id"],
        ];
    }
}
