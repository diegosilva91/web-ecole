<?php

namespace Mi-empresa\Api\Domain\Adapter;

use Symfony\Component\HttpFoundation\File\File;

interface CdnAdapter
{
    public function base(): string;

    public function image(string $path): string;

    public function upload(string $path, File $file): bool;
}
