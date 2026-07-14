<?php

namespace Lifecole\Shared\Domain\Repository;

use Illuminate\Mail\Mailable;

/**
 * FIXME
 * Este repositorio tiene una dependencia con Laravel.
 * Habrá que hacer una refactorización para crear una clase propia que contenga la información
 * que consideremos necesaria para los mails de Lifecole
 */

interface Mailer
{
    public function send(Mailable $mailable): void;
}
