<?php

namespace Lifecole\Api\Domain\DTO;

class LeadTeacher
{
    private \DateTime $receivedAt;

    private function __construct(
        private string $email,
        private string $phone,
        private string $name,
        private string $interest,
    ) {
        $this->receivedAt = new \DateTime('now');
    }

    public function email(): string
    {
        return $this->email;
    }

    public function phone(): string
    {
        return $this->phone;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function receivedAt(): \DateTime
    {
        return $this->receivedAt;
    }

    public function interest(): string
    {
        return $this->interest;
    }

    public static function createFromLead(
        string $email,
        string $phone,
        string $name,
        string $interest,
    ): self
    {
        return new self($email, $phone, $name,  $interest);
    }
}
