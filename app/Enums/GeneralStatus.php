<?php

namespace App\Enums;

enum GeneralStatus: int
{
    case PENDING   = 0;
    case ACTIVE    = 1;
    case UPDATED   = 2;
    case DELETED   = 3;

    public function label(): string
    {
        return match($this) {
            static::PENDING   => 'Pending',
            static::ACTIVE    => 'Active',
            static::UPDATED   => 'Updated',
            static::DELETED   => 'Deleted',
        };
    }
}
