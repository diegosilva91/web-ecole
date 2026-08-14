<?php

namespace Mi-empresa\Api\Application\Paypal;

use App\Mail\Internal\ReportCommandError;
use Illuminate\Support\Facades\Mail;

class UpdatePaymentPaypalCommandHandler
{
    public function __invoke(UpdatePaymentPaypalCommand $updatePaymentPaypalCommand)
    {
        try {
            $promotionPurchasePayment = $updatePaymentPaypalCommand->promotionPurchasePayment();
            $captures = $updatePaymentPaypalCommand->paypalPayment()->paymentsPaypal();
            if (array_key_exists('captures', $captures) && isset($captures['captures'][0])) {
                $transactionId = array_key_exists('id', $captures['captures'][0]) ? $captures['captures'][0]['id'] : null;
            }
            if (isset($transactionId)) {
                $promotionPurchasePayment->paypal_transaction_id = $transactionId;
            }
            $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
            $user = $promotionPurchase->user();
            $customer = $user->customer()->first();
            if (isset($user)) {
                $user->paypal_payer_id = $updatePaymentPaypalCommand->paypalPayment()->payerId();
                $user->save();
            }
            if (isset($customer)) {
                $customer->paypal_payer_id = $updatePaymentPaypalCommand->paypalPayment()->payerId();
                $customer->save();
            }
        } catch (\Exception $exception) {
            try {
                Mail::send(new ReportCommandError(static::class, [
                    'promotionPurchasePayment' => isset($promotionPurchasePayment) ? optional($promotionPurchasePayment)->id : ''
                ], $exception));
            } catch (\Throwable $throwableToIgnore) {
            }
        }
    }
}
