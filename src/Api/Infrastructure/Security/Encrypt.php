<?php

namespace Mi-empresa\Api\Infrastructure\Security;

use Illuminate\Support\Facades\Crypt;

final class Encrypt
{
    public function encrypt($token): string
    {
        return Crypt::encrypt($token);
    }
}
