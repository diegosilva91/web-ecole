<?php

namespace Mi-empresa\Api\Domain\Repository;

use Mi-empresa\Api\Domain\DTO\LeadTeacher;
use Mi-empresa\Api\Domain\DTO\LeadUser;

interface LeadRepository
{
    public function sendLeadUser(LeadUser $lead): void;

    public function sendLeadTeacher(LeadTeacher $lead): void;
}
