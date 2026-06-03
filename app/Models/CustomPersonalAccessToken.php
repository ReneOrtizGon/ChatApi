<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Firebase\JWT\JWT;

class CustomPersonalAccessToken extends SanctumPersonalAccessToken
{
    // Override serialization to output a signed JWT payload
    public static function findToken($token)
    {
        // Decode logic if you choose to decode the incoming JWT incoming string
        // extracting the database token ID from the JWT payload
        return parent::findToken($token);
    }
}
