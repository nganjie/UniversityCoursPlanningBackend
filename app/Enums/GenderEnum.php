<?php

namespace App\Enums;

enum GenderEnum:string
{
    case MALE = "M";
    case FEMALE = "F";

    public function label():string{
        return match ($this) {
            self::MALE => "M",
            self::FEMALE => "F",
        };
    }

    public static function toArray():array{
        return array_column(GenderEnum::cases(),"value");
    }
}
