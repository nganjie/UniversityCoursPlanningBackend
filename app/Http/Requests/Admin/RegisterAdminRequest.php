<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterAdminRequest extends FormRequest
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
            "first_name"=>["required","string"],
        "last_name"=> ["required","string"],
        "email"=> ["required","unique:admins,email","string"],
        "password"=> ["required","string"],
        "phone"=> ["required","string"],
        "gender"=> ["required",new Enum(GenderEnum::class)],
        ];
    }
}
