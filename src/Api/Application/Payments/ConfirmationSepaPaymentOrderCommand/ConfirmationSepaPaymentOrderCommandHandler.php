<?php

namespace Mi-empresa\Api\Application\Payments\ConfirmationSepaPaymentOrderCommand;

use App\Course;
use App\Mail\ConfirmationSepaPayment;
use App\UserAssistant;
use Illuminate\Support\Facades\Mail;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class ConfirmationSepaPaymentOrderCommandHandler implements CommandHandler
{
    public function __invoke(ConfirmationSepaPaymentOrderCommand $confirmationSepaPaymentOrderCommand)
    {
        $promotionPurchasePayment = $confirmationSepaPaymentOrderCommand->promotionPurchasePayment();
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

        Mail::send(new ConfirmationSepaPayment(
            $user,
            $course,
            $promotion,
            $promotionPurchasePayment,
            $userAssistant,
        ));
    }
}
