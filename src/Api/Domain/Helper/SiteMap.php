<?php

namespace Lifecole\Api\Domain\Helper;

class SiteMap
{
    const START_TAG = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    const END_TAG = '</urlset>';

    private string $xmlContent = '';

    public function add(Url $siteMapUrl): void
    {
        $this->xmlContent .= $siteMapUrl->build();
    }

    public function build(): string
    {
        return self::START_TAG . $this->xmlContent . self::END_TAG;
    }
}
