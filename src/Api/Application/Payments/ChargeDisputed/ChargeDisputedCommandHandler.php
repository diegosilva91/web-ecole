<?php

namespace Lifecole\Api\Application\Payments\ChargeDisputed;

use App\Mail\Internal\InformationEvent;
use Lifecole\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Lifecole\Shared\Domain\Repository\Mailer;

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
                'to' => [['email' => 'belen@lifecole.com', 'Belén'],['email' => 'eva@lifecole.com', 'Eva'],['email' => 'antonio@lifecole.com', 'Antonio']],
                'subject' => 'Nuevo pago disputado',
                'html' => 'Se ha creado una nueva disputa en Stripe.<br>Cliente: '.$user->email.'<br>Id pago Stripe: ' . $paymentIntent
            ]);
            $this->mailer->send($informationEvent);
        }

    }
}
