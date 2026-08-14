<?php

namespace Mi-empresa\Api\Application\Payments\ConfirmationPaymentOrderCommand;

use App\Course;
use App\Mail\Internal\PaymentConfirmation;
use App\UserAssistant;
use Illuminate\Support\Facades\Mail;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class ConfirmationPaymentOrderCommandHandler implements CommandHandler
{
    public function __invoke(ConfirmationPaymentOrderCommand $confirmationPaymentOrderCommand)
    {
        $promotionPurchasePayment = $confirmationPaymentOrderCommand->promotionPurchasePayment();
        $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
        $promotion = $promotionPurchase->promotion();
        /** @var Course $course */
        $course = $promotion->course()->first();
        $user = $promotionPurchase->user();
        $promotionPurchaseAssitants = $promotionPurchase->promotionPurchaseAssistants()->get();
        $userAssistantIds = [];
        foreach ($promotionPurchaseAssitants as $promotionPurchaseAssitant) {
            $userAssistantIds[] = $promotionPurchaseAssitant->user_assistant_id;
        }
        $userAssistant = UserAssistant::whereIn('id', $userAssistantIds)->get();

        Mail::send(new PaymentConfirmation(
            $promotionPurchasePayment, $course, $user, $promotion, $userAssistant
        ));
    }
}
