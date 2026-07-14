<?php

namespace App\Listeners;

use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;
use Lifecole\Shared\Domain\Event\CustomerWasCreated;

class SendWelcomeEmailToCustomer
{
    public function handle(CustomerWasCreated $event): void
    {
        Mail::send(new WelcomeUser($event->user()));
    }
}
