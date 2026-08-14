<?php

namespace Mi-empresa\Api\Application\Payments\ConfirmationPurchaseOrderCommand;

use App\Course;
use App\Mail\ConfirmationOrder;
use App\UserAssistant;
use Illuminate\Support\Facades\Mail;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class ConfirmationPurchaseOrderCommandHandler implements CommandHandler
{
    public function __invoke(ConfirmationPurchaseOrderCommand $confirmationPurchaseOrderCommand)
    {
        $promotionPurchasePayment = $confirmationPurchaseOrderCommand->promotionPurchasePayment();
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

        Mail::send(new ConfirmationOrder(
            $user,
            $course,
            $promotion,
            $promotionPurchasePayment,
            $userAssistant,
        ));
    }
}
