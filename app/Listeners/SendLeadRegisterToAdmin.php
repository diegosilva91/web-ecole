<?php

namespace App\Listeners;

use App\Jobs\SendLeadUser;
use App\User;
use Lifecole\Api\Domain\DTO\LeadUser;
use Lifecole\Shared\Domain\Event\CustomerWasCreated;

class SendLeadRegisterToAdmin
{
    public function handle(CustomerWasCreated $event): void
    {
        $user = $event->user();

        if ($user->type_user === User::CUSTOMER) {
            SendLeadUser::dispatch(
                LeadUser::createFromRegister(
                    $user->email,
                    ($user->phone !== null) ? $user->phone : '',
                    $user->name
                )
            );
        }
    }
}
