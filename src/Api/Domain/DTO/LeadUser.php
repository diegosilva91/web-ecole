<?php

namespace Mi-empresa\Api\Domain\DTO;

class LeadUser
{
    // The same values as admin
    const ORIGIN_LEAD = 1;
    const ORIGIN_CONTACT = 2;
    const ORIGIN_REGISTER = 3;

    private \DateTime $receivedAt;

    private function __construct(
        private string $email,
        private string $phone,
        private string $name,
        private string $message,
        private string $interest,
        private int $origin,
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

    public function message(): string
    {
        return $this->message;
    }

    public function interest(): string
    {
        return $this->interest;
    }

    public function origin(): int
    {
        return $this->origin;
    }

    public static function createFromContact(
        string $email,
        string $phone,
        string $name,
        string $message,
        string $interest,
    ): self
    {
        return new self($email, $phone, $name, $message, $interest, self::ORIGIN_CONTACT);
    }

    public static function createFromRegister(
        string $email,
        string $phone,
        string $name,
    ): self
    {
        return new self($email, $phone, $name, '', '', self::ORIGIN_REGISTER);
    }

    public static function createFromLead(
        string $email,
        string $phone,
        string $name,
        string $interest,
    ): self
    {
        return new self($email, $phone, $name, '', $interest, self::ORIGIN_LEAD);
    }
}
