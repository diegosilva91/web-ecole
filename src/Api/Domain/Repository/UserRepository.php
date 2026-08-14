<?php

namespace Mi-empresa\Api\Domain\Repository;

use App\User;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

interface UserRepository
{
    public function getUsersProfile(UserId $userId): ?User;

    public function getUserById($id): ?User;

    public function firstCustomerOrCreateByEmail($email): ?User;

    public function getUsersWithTeacherRoleIsFeatured($is_featured): array;
}
