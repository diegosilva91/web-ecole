<?php

namespace Lifecole\Api\Application\Users\GetUsersProfile;

use App\User;
use Lifecole\Api\Domain\Repository\UserRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

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
