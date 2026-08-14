<?php

namespace Mi-empresa\Api\Application\Users\GetUsersWithTeacherRole;

use Mi-empresa\Api\Domain\Repository\UserRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

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
