<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mi-empresa\Api\Domain\DTO\LeadTeacher;
use Mi-empresa\Api\Domain\Repository\LeadRepository;

class SendLeadTeacher implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private LeadTeacher $leadTeacher)
    {
    }

    public function handle(LeadRepository $leadRepository): void
    {
        $leadRepository->sendLeadTeacher($this->leadTeacher);
    }
}
