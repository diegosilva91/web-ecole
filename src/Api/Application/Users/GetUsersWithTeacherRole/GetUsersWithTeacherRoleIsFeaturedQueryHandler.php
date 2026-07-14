<?php

namespace Lifecole\Api\Application\Users\GetUsersWithTeacherRole;

use Lifecole\Api\Domain\Repository\UserRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

class GetUsersWithTeacherRoleIsFeaturedQueryHandler implements QueryHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(GetUsersWithTeacherRoleIsFeaturedQuery $getUsersWithTeacherRoleIsFeaturedQuery): array
    {
        return $this->userRepository->getUsersWithTeacherRoleIsFeatured(
            $getUsersWithTeacherRoleIsFeaturedQuery->isFeatured()
        );
    }
}
