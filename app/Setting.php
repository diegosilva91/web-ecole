<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getIntValue(): ?int
    {
        return isset($this->value) ? (int)$this->value : null;
    }

    public function getArrayValue(): ?array
    {
        return isset($this->value) ? json_decode($this->value, true) : null;
    }
}
