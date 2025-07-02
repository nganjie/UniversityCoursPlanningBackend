<?php

namespace App\Http\Requests\Batiment;

use App\Enums\BatimentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateBatimentRequest extends FormRequest
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
            "name"=>["required","string"],
            "short_name"=>["required","string"],
            "adress"=>["required","string"],
            "type"=>["required",new Enum(BatimentEnum::class)],
        ];
    }
}
