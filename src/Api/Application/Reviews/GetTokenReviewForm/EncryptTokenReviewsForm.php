<?php

namespace Mi-empresa\Api\Application\Reviews\GetTokenReviewForm;

use Mi-empresa\Api\Domain\Adapter\EncryptionAdapter;

class EncryptTokenReviewsForm
{
    public function __construct(private EncryptionAdapter $encryptionAdapter)
    {
    }

    public function __invoke(int $user_id, int $course_id): string
    {
        return $this->encryptionAdapter->encrypt(json_encode(['course_id' => $course_id,'user_id' => $user_id]));
    }
}
