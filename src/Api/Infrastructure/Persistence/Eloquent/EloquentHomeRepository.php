<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use Lifecole\Api\Domain\DTO\TopBannerHome;
use Lifecole\Api\Domain\Repository\HomeRepository;
use Lifecole\Api\Domain\Repository\SettingRepository;

class EloquentHomeRepository implements HomeRepository
{
    public function __construct(private SettingRepository $settingRepository)
    {
    }

    public function getTopBannerHome(): TopBannerHome
    {
        $settingBannerTop = $this->settingRepository->findByKey('home.banner_top');
        $topBannerHome = new TopBannerHome();
        if ($settingBannerTop) {
            $data = $settingBannerTop->getArrayValue();
            $topBannerHome->setTitle($data['title'] ?? null);
            $topBannerHome->setSubtitle($data['subtitle'] ?? null);
            $topBannerHome->setLink($data['link'] ?? null);
            $topBannerHome->setActivation(isset($data['activation']) ? \DateTime::createFromFormat('d/m/Y H:i:s', $data['activation']) : null);
            $topBannerHome->setDeactivation(isset($data['deactivation']) ? \DateTime::createFromFormat('d/m/Y H:i:s', $data['deactivation']) : null);
        }

        return $topBannerHome;
    }
}
