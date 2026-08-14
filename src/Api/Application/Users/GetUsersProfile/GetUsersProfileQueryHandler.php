<?php

namespace Mi-empresa\Api\Application\Users\GetUsersProfile;

use App\User;
use Mi-empresa\Api\Domain\Repository\UserRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetUsersProfileQueryHandler implements QueryHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(GetUsersProfileQuery $getUsersProfileQuery): ?User
    {
        return $this->userRepository->getUsersProfile($getUsersProfileQuery->userId());
    }
}
