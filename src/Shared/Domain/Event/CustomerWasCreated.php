<?php

namespace Lifecole\Shared\Domain\Event;

use App\User;

class CustomerWasCreated
{
    public function __construct(private User $user)
    {
    }

    public function user(): User
    {
        return $this->user;
    }
}
