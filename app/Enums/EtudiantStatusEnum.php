<?php

namespace App\Enums;

enum EtudiantStatusEnum:string
{
    case Active="active";
    case Desactive="desactive";
    case Valided="valided";
    case Invalided= "invalided";

    public function label():string{
        return match($this){
            self::Active => "active",
            self:: Desactive => "desactive",
            self::Valided => "valided",
            self::Invalided => "invalided",
        };
    }
    public static function toArray():array{
        return array_column(EtudiantStatusEnum::cases(),"value");
    }
}
