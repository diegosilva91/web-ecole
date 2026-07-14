<?php

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Api\Domain\DTO\LeadTeacher;
use Lifecole\Api\Domain\DTO\LeadUser;

interface LeadRepository
{
    public function sendLeadUser(LeadUser $lead): void;

    public function sendLeadTeacher(LeadTeacher $lead): void;
}
