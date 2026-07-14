<?php

namespace Lifecole\Api\Infrastructure\Security;

use Illuminate\Support\Facades\Crypt;

final class Decrypt
{
    public function decrypt($token): string
    {
        return Crypt::decrypt($token);
    }
}
