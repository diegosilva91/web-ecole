<?php

namespace Mi-empresa\Api\Domain\Helper;

class Url
{
    private string $url;
    private string $lastUpdate;
    private string $frequency;
    private string $priority;

    public static function create(string $url)
    {
        $newNode = new self();
        $newNode->url = url($url);
        return $newNode;
    }

    public function lastUpdate(string $lastUpdate): self
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    public function frequency(string $frequency): self
    {
        $this->frequency = $frequency;
        return $this;
    }

    public function priority(string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function build(): string
    {
        return "<url>" .
            "<loc>$this->url</loc>" .
            "<lastmod>$this->lastUpdate</lastmod>" .
            "<changefreq>$this->frequency</changefreq>" .
            "<priority>$this->priority</priority>" .
            "</url>";
    }
}
