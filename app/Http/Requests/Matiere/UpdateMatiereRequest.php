<?php

namespace App\Http\Requests\Matiere;

use App\Enums\MatiereTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateMatiereRequest extends FormRequest
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
             "code"=>["required","string"],
            "name"=>["required","string"],
            "niveau_id"=>["required_if:type,".MatiereTypeEnum::GLOBAL->label(),"string","exists:niveaux,id"],
            "sous_niveau_id"=>["required_if:type,".MatiereTypeEnum::SINGLE->label(),"string","exists:sous_niveaux,id"],
            "type"=>["required",new Enum(MatiereTypeEnum::class)],
        ];
    }
}
