<?php

namespace App\Enums;


enum BatimentEnum :string
{
    case SINGLE="single";
    case MULTIPLE="multiple";

    public function label():string{
        return match($this){
            self::SINGLE => "single",
            self::MULTIPLE => "multiple",
        };
    }
    public static function toArray(): array{
        return array_column(BatimentEnum::cases(),'value');
    }
}
