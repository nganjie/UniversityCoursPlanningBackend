<?php

namespace App\Enums;

enum DayEnum:int
{
    case MONDAY=1;
    case TUESDAY= 2;
    case WEDNESDAY= 3;
    case THURSDAY= 4;
    case FRIDAY= 5;
    case SATURDAY= 6;
    case SUNDAY= 7;
    public function label():int{
        return $this->value;
    }

    public static function toArray():array{
        return array_column(DayEnum::cases(),"value");
    }
}
