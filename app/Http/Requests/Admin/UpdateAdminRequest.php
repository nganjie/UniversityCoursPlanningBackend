<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateAdminRequest extends FormRequest
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
            "first_name"=>["string"],
        "last_name"=> ["string"],
        "email"=> ["unique:admins,email","string"],
        "password"=> ["string"],
        "phone"=> ["string"],
        "gender"=> [new Enum(GenderEnum::class)],
        ];
    }
}
