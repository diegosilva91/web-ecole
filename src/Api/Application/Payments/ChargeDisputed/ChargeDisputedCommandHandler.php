<?php

namespace Mi-empresa\Api\Application\Payments\ChargeDisputed;

use App\Mail\Internal\InformationEvent;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Shared\Domain\Repository\Mailer;

class ChargeDisputedCommandHandler
{
    public function __construct(
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
        private Mailer $mailer
    ) {
    }

    public function __invoke(ChargeDisputedCommand $chargeDisputedCommand)
    {
        $paymentIntent = $chargeDisputedCommand->paymentIntent();
        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findByPaymentIntentAndPaymentStatus($paymentIntent, ['succeeded']);

        if (isset($promotionPurchasePayment)) {
            $promotionPurchasePayment->payment_status = 'disputed';
            $promotionPurchasePayment->save();

            $user = $promotionPurchasePayment->promotionPurchase()->user();

            $informationEvent = new InformationEvent([
                'to' => [['email' => 'belen@mi-empresa.com', 'Belén'],['email' => 'eva@mi-empresa.com', 'Eva'],['email' => 'antonio@mi-empresa.com', 'Antonio']],
                'subject' => 'Nuevo pago disputado',
                'html' => 'Se ha creado una nueva disputa en Stripe.<br>Cliente: '.$user->email.'<br>Id pago Stripe: ' . $paymentIntent
            ]);
            $this->mailer->send($informationEvent);
        }

    }
}
