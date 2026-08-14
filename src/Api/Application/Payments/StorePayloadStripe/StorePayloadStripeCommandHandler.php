<?php

namespace Mi-empresa\Api\Application\Payments\StorePayloadStripe;

use App\PaymentsEvent;
use Mi-empresa\Api\Domain\Repository\PaymentsEventRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class StorePayloadStripeCommandHandler implements CommandHandler
{
    public function __construct(private PaymentsEventRepository $paymentsEventRepository)
    {
    }

    public function __invoke(StorePayloadStripeCommand $storePayloadStripeCommand)
    {
        $dataFind = [
            'provider' => PaymentsEvent::PROVIDER_STRIPE,
            'payment_event_id' => $storePayloadStripeCommand->data()['id'],

        ];
        $dataUpdate = [
            'event_type' => $storePayloadStripeCommand->data()['type'],
            'payload' => json_encode($storePayloadStripeCommand->data()),
            'status' => $storePayloadStripeCommand->status()
        ];

        $this->paymentsEventRepository->updateOrCreate($dataFind, $dataUpdate);
    }
}
