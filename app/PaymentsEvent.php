<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentsEvent extends Model
{
    public const STATUS_PENDING = 1;
    public const STATUS_SUCCEEDED = 2;
    public const STATUS_IGNORED = 3;
    public const STATUS_FAILED = 4;

    public const PROVIDER_STRIPE = 1;

    protected $fillable = ['provider', 'promotion_purchase_id', 'event_type', 'payload', 'payment_event_id', 'status'];

    public function processPayload(): array
    {
        return json_decode($this->payload, true);
    }
}
