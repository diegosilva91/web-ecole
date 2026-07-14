<?php

namespace App\Console\Commands\Tmp;

use App\PromotionPurchase;
use App\PromotionPurchasePayment;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Console\Command;
use Lifecole\Api\Domain\Repository\StripePaymentsRepository;

class ChangeCancelAtDateOnStripe extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tech:change_cancel_at_date_on_stripe';

    /**
     * The console command description.
     */
    protected $description = 'Change de cancel_at date of any subscription of Stripe';

    public function __construct(private StripePaymentsRepository $stripePaymentsRepository)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        die('Cuidado este proceso debe lanzarse con precaución');

        $list = PromotionPurchase::where(['paid' => PromotionPurchase::PAID_PAID, 'type_payment' => PromotionPurchase::PAYMENT_MONTHLY])
            ->where("id", ">", 12101)
            ->orderBy('id', 'asc')
            ->get();
        dump(count($list));

        /** @var PromotionPurchase $purchase */
        foreach ($list as $purchase) {
            $paymentToProcess = null;
            $payments = $purchase->payments();
            /** @var PromotionPurchasePayment $payment */
            foreach ($payments as $payment) {
                if ($payment->stripe_subscription_token) {
                    $paymentToProcess = $payment;
                    break;
                }
            }

            if ($paymentToProcess == null) {
                continue;
            }

            $customerId = $paymentToProcess->stripe_customer_token;
            $subscriptionId = $paymentToProcess->stripe_subscription_token;

            // Casos especiales
            if (
                $purchase->id == 10891 // Es un pago antiguo perteneciente a una suscripcion que no tiene código de suscripcion
            ) {
                continue;
            }

            if (
                $purchase->id == 14931 // El primer pago lo hizo con otra suscripcion
            ) {
                $customerId = 'cus_Kf1VE8n8bVhxoN';
                $subscriptionId = 'sub_1JzhSKEbTyb55aaZOU7BYWe6';
            }

            if (
                $purchase->id == 15691 // El primer pago lo hizo con paypal
            ) {
                $customerId = 'cus_KgyJsDD0IAkm6O';
                $subscriptionId = 'sub_1K1aRFEbTyb55aaZLVyymhOM';
            }

            if (
                $purchase->id == 22521 // El primer pago lo hizo con transfer
            ) {
                $customerId = 'cus_L5EerjFGqEaxrU';
                $subscriptionId = 'sub_1KaewLEbTyb55aaZOIWKSOme';
            }

            if (
                $purchase->id == 13371 // El primer pago lo hizo con otra suscripción
            ) {
                $customerId = 'cus_KXSnKBSl0EYkjH';
                $subscriptionId = 'sub_1JsNrkEbTyb55aaZV6scRpwG';
            }

            if (
                $purchase->id == 17351 // El primer pago lo hizo con otra suscripción
            ) {
                $customerId = 'cus_KSKRKakWoIFFoI';
                $subscriptionId = 'sub_1KEUh6EbTyb55aaZJQl9bdzi';
            }


            //// FAKE
            //$customerId = 'cus_LcE3TFlzoq3d4d';
            //$subscriptionId = 'sub_1Kuzb6EbTyb55aaZuhEvACY7';
            /// FAKE

            echo "---------\n";
            echo 'Procesando: ' . $subscriptionId . " -> " . $purchase->id . " -> " . $paymentToProcess->id . "\n";
            $subscription = $this->stripePaymentsRepository->getSubscription(
                $customerId,
                $subscriptionId
            );

            $status = $subscription['status'];
            if ($status == 'canceled') {
                continue;
            }

            /*
            $upcomingInvoice = Stripe::invoices()->upcomingInvoice($customerId, $subscriptionId);
            dump($subscriptionId);
            dump(Carbon::parse($upcomingInvoice['created'])->format('Y-m-d H:i:s'));
            dump(Carbon::parse($upcomingInvoice['date'])->format('Y-m-d H:i:s'));
            dump(Carbon::parse($upcomingInvoice['period_end'])->format('Y-m-d H:i:s'));
            $current_period_end = $subscription['current_period_end'];
            */

            $date_current_period_end = Carbon::parse($subscription['current_period_end'])->format('Y-m');
            if ($date_current_period_end != '2022-08') {
                dump('No es Agosto', $subscriptionId, $date_current_period_end);
                continue;
            }

            //$trial_end = Carbon::parse($subscription['current_period_end'])->addMonths(2);
            //if (Carbon::parse($subscription['current_period_end'])->format('d') == '30') {
            //$trial_end = $trial_end->addDay();
            //}
            $sub = Carbon::parse($subscription['current_period_end'])->format('d') - 8;
            $trial_end = Carbon::parse($subscription['current_period_end'])->subDays($sub);

            dump(Carbon::parse($subscription['current_period_end'])->format('Y-m-d H:i:s'));
            dump($trial_end->format('Y-m-d H:i:s'));


            $this->stripePaymentsRepository->updateSubscription(
                $customerId,
                $subscriptionId,
                [
                    'trial_end' => $trial_end->timestamp,
                    'proration_behavior' => 'none',
                ]
            );

            //die('Comprueba');
            sleep(3);
        }

        return 0;
    }
}
