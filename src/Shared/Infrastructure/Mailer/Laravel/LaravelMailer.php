<?php

namespace Lifecole\Shared\Infrastructure\Mailer\Laravel;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Lifecole\Shared\Domain\Repository\Mailer;

class LaravelMailer implements Mailer
{
    public function send(Mailable $mailable): void
    {
        Mail::send($mailable);
    }
}
