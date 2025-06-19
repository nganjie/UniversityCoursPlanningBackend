<?php

namespace App\Enums;

enum StatusEnum:string
{
    case ENABLED="enabled";
    case DISABLED= "disableD";
    case ACTIVE = "active";
    case INACTIVE = "inactive";
    case PENDING ="pending";
    case CANCELLED = "cancelled";

    public function label():string{
        return match ($this) {
            self::ENABLED => "enabled",
            self::DISABLED => "disabled",
            self::ACTIVE => 'active',
            self::PENDING => 'pending',
            self::CANCELLED => 'canceled',
            self::INACTIVE=>'inactive'
        };
    }
    public static function toArray():array{
        return array_column(StatusEnum::cases(),"value");
    }
}
