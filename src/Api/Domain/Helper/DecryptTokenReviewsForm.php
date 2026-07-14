<?php

namespace Lifecole\Api\Domain\Helper;

use Lifecole\Api\Domain\Adapter\EncryptionAdapter;

class DecryptTokenReviewsForm
{
    private EncryptionAdapter $encryptionAdapter;

    public function __construct(EncryptionAdapter $encryptionAdapter)
    {
        $this->encryptionAdapter = $encryptionAdapter;
    }

    public function dataFromToken(string $token): array
    {
        return $this->encryptionAdapter->decrypt($token);
    }
}
