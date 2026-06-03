<?php

namespace App\Enums;

enum MessageType: int
{
    case RESPONSE   = 0;
    case PRINCIPAL  = 1;

    public function label(): string
    {
        return match($this) {
            static::RESPONSE   => 'Response',
            static::PRINCIPAL  => 'Principal',
        };
    }
}
