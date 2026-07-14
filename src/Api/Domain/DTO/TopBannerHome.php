<?php

namespace Lifecole\Api\Domain\DTO;

class TopBannerHome
{
    private ?string $title = null;
    private ?string $subtitle = null;
    private ?string $link = null;
    private ?\DateTime $activation = null;
    private ?\DateTime $deactivation = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getActivation(): ?\DateTime
    {
        return $this->activation;
    }

    public function setActivation(?\DateTime $activation): void
    {
        $this->activation = $activation;
    }

    public function getDeactivation(): ?\DateTime
    {
        return $this->deactivation;
    }

    public function setDeactivation(?\DateTime $deactivation): void
    {
        $this->deactivation = $deactivation;
    }

    public function getData(): array
    {
        $now = new \DateTime();
        $visible = isset($this->activation) && ($this->activation->getTimestamp() <= $now->getTimestamp());
        $secondsTimestamp = 0;
        $time = [];
        if ($visible && isset($this->deactivation)) {
            $visible = ($this->deactivation->getTimestamp() >= $now->getTimestamp());
            $secondsTimestamp = $this->deactivation->getTimestamp() - $now->getTimestamp();
            $time = [
                'days' => gmdate("d", $secondsTimestamp),
                'hours' => gmdate("H", $secondsTimestamp),
                'minutes' => gmdate("i", $secondsTimestamp),
                'seconds' => gmdate("s", $secondsTimestamp),
            ];
        }
        return [
            'visible' => $visible,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'link' => $this->link,
            'seconds' => $secondsTimestamp,
            'time' => $time
        ];
    }
}
