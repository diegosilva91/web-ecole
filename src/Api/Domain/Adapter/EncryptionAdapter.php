<?php

namespace Mi-empresa\Api\Domain\Adapter;

interface EncryptionAdapter
{
    public function encrypt(string $payload): string;

    public function decrypt(string $token): array;
}
