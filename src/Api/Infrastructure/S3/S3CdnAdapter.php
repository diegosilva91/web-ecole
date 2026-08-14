<?php

namespace Mi-empresa\Api\Infrastructure\S3;

use Illuminate\Support\Facades\Storage;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Symfony\Component\HttpFoundation\File\File;

class S3CdnAdapter implements CdnAdapter
{
    private string $urlCdn;

    public function __construct(private array $conf)
    {
        $this->urlCdn = 'https://' . $conf['bucket'] . '.s3.' . $conf['region'] . '.amazonaws.com/' . $conf['root'] . '/';
    }

    public function base(): string
    {
        return $this->urlCdn;
    }

    public function image(string $path): string
    {
        return $this->urlCdn . $path;
    }

    public function upload(string $path, File $file): bool
    {
        return Storage::disk('s3')->put($path, file_get_contents($file), 'public');
    }
}
