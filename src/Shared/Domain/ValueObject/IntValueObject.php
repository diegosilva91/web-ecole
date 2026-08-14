<?php

declare(strict_types=1);

namespace Mi-empresa\Shared\Domain\ValueObject;

abstract class IntValueObject
{
    protected int $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function create(int $value): static
    {
        return new static($value);
    }
}
