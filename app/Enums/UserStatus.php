<?php

namespace App\Enums;

enum UserStatus: int
{
    case PENDING   = 0;
    case ACTIVE    = 1;
    case SUSPENDED = 2;
    case CANCELED  = 3;

    public function label(): string
    {
        return match($this) {
            static::PENDING   => 'Pending',
            static::ACTIVE    => 'Active',
            static::SUSPENDED => 'Suspended',
            static::CANCELED  => 'Canceled by user',
        };
    }
}
