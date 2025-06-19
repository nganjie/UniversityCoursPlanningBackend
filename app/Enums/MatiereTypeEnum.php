<?php

namespace App\Enums;

enum MatiereTypeEnum:string
{
    case GLOBAL="global";
    case SINGLE="single";

    public function label():string{
        return match ($this) {
            self::GLOBAL => "global",
            self::SINGLE => "single",
        };
    }

    public static function toArray():array{
        return array_column(MatiereTypeEnum::cases(),"value");
    }
}
