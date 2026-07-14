<?php

namespace Lifecole\Api\Application\Payments\SepaChargeSucceededUpdatePayment;

use App\PaymentsEvent;
use Lifecole\Event\Domain\Bus\Command\Command;

class SepaChargeSucceededUpdateCommand extends Command
{
    private array $payload;

    public function __construct(PaymentsEvent $paymentEvent)
    {
        parent::__construct();
        $this->payload = $paymentEvent->processPayload();
    }

    public function paymentIntentId(): ?string
    {
        if (isset($this->payload['data']['object']['payment_intent'])) {
            return $this->payload['data']['object']['payment_intent'];
        }
        return null;
    }

    public function chargeId(): ?string
    {
        if (isset($this->payload['data']['object']['id'])) {
            return $this->payload['data']['object']['id'];
        }
        return null;
    }

    public function customerMail(): ?string
    {
        if (isset($this->payload['data']['object']['receipt_email'])) {
            return $this->payload['data']['object']['receipt_email'];
        } else if (isset($this->payload['data']['object']['billing_details']['email'])) {
            return $this->payload['data']['object']['billing_details']['email'];
        }
        return null;
    }

}
