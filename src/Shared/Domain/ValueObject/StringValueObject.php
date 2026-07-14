<?php

declare(strict_types=1);

namespace Lifecole\Shared\Domain\ValueObject;

abstract class StringValueObject
{
    protected string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }

    public static function create(string $value): static
    {
        return new static($value);
    }
}
