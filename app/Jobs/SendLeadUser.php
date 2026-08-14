<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mi-empresa\Api\Domain\DTO\LeadUser;
use Mi-empresa\Api\Domain\Repository\LeadRepository;

class SendLeadUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private LeadUser $leadUser)
    {
    }

    public function handle(LeadRepository $leadRepository): void
    {
        $leadRepository->sendLeadUser($this->leadUser);
    }
}
