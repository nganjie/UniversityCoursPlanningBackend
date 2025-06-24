<?php

namespace App\Enums;

enum RoleEnum:string
{
    case TechnicalSupport="Technical-Support";
    case ChefEtablissement="chef-etablissement";

    public function label():string{
        return match ($this) {
            self::TechnicalSupport => "Technical-Support",
            self::ChefEtablissement => "chef-etablissement",
        };
    }
    public static function toArray():array{
        return array_column(RoleEnum::cases(),'value');
    }
}
