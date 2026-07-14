<?php

namespace App\Console\Commands\Tech;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Console\Command;

class ForcePaymentsOnStripe extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'tech:force_payments_on_stripe';

    /**
     * The console command description.
     */
    protected $description = 'Fuerza los pagos de Stripe que se han quedado colgados porque no tienen método de pago asociado';

    public function handle(): int
    {
        die('Cuidado este proceso debe lanzarse con precaución');

        $preparedPayments = \App\PromotionPurchasePayment::whereIn('payment_status', ['failed'])->get();
        //$preparedPayments = \App\PromotionPurchasePayment::whereIn('payment_status', ['prepared'])->get();
        dump(count($preparedPayments));

        /** @var \App\PromotionPurchasePayment $preparedPayment */
        foreach ($preparedPayments as $preparedPayment) {
            //dump($preparedPayment->id);
            //dump($preparedPayment->created_at->toDateTimeString());

            // Controlamos que solo estamos procesando los últimos pagos que han sido preparados
            // No queremos forzar pagos antiguos que ya sabemos que no fueron pagados
            $minDateCreation = '2022-05-25 09:00:00';
            if (strtotime($preparedPayment->created_at->toDateTimeString()) < strtotime($minDateCreation)) {
                continue;
            }

            $customer = $preparedPayment->stripe_customer_token;
            $currentPaymentIntentToken = $preparedPayment->stripe_payment_intent_token;

/*
            // Por si queremos trabajar con un customer en concreto para pruebas
            if (!in_array($customer, [
                'cus_KRBQCtGpA0PfqQ',
            ])) {
                continue;
            }
*/
            $paymentIntents = \Cartalyst\Stripe\Laravel\Facades\Stripe::paymentIntents()->all(['customer' => $customer]);
            $paymentIntents = $paymentIntents['data'];
            foreach ($paymentIntents as $paymentIntent) {
                //dump($paymentIntent['id'], $paymentIntent['status']);

                if (isset($currentPaymentIntentToken) && $currentPaymentIntentToken != $paymentIntent['id']) {
                    continue;
                }

                dump('------------- Proceso --------------', $currentPaymentIntentToken, $paymentIntent['status'], (isset($paymentIntent['last_payment_error'])) ? $paymentIntent['last_payment_error']['message'] : '');

                // Si no tiene mensaje del último error es que corresponde a error por no tener source
                // En cualquier otro caso suele ser porque no había fondos o la tarjeta era incorrecta, en estos casos también vamos
                // a querer forzar pero no hasta haber forzado los del tipo requires_source
                if (isset($paymentIntent['last_payment_error']) && count($paymentIntent['last_payment_error']) > 0) {
                    continue;
                }

                // requires_source es el estado que nos indica que no se ha podido cobrar porque no había método de pago asociado, cualquier
                // otro estado no nos interesa
                if ($paymentIntent['status'] == 'requires_source') {
                    $created = $paymentIntent['created'];
                    //dump($created);
                    if ($created < strtotime($minDateCreation)) {
                        continue;
                    }

                    dump('------------- Intento --------------', $customer, $currentPaymentIntentToken);
                    //dd('Intento ' . $customer);

                    $paid = false;

                    $sources = Stripe::customers()->payments($customer, ['type' => 'sepa_debit']);
                    $sources = $sources['data'];
                    //dump(count($sources) . ' SEPAS');
                    if (count($sources) > 0) {
                        foreach ($sources as $source) {
                            try {
                                $payment_method = $source['id'];
                                $paymentIntent = \Cartalyst\Stripe\Laravel\Facades\Stripe::paymentIntents()->confirm($paymentIntent['id'], [
                                    'payment_method' => $payment_method
                                ]);

                                //dump($paymentIntent);
                                dump('Pagado: ' . $paymentIntent['id']);
                                $paid = true;
                                //die('comprueba');
                                break;
                            } catch (\Exception $e) {
                                dump('Error pago', $e->getMessage());
                            }
                        }
                    }

                    if (!$paid) {
                        $sources = \Cartalyst\Stripe\Laravel\Facades\Stripe::customers()->payments($customer, ['type' => 'card']);
                        $sources = $sources['data'];
                        //dump(count($sources) . ' TARJETAS');
                        if (count($sources) > 0) {
                            foreach ($sources as $source) {
                                try {
                                    $payment_method = $source['id'];
                                    $paymentIntent = \Cartalyst\Stripe\Laravel\Facades\Stripe::paymentIntents()->confirm($paymentIntent['id'], [
                                        'payment_method' => $payment_method
                                    ]);

                                    //dump($paymentIntent);
                                    dump('Pagado: ' . $paymentIntent['id']);
                                    $paid = true;
                                    //die('comprueba');
                                    break;
                                } catch (\Exception $e) {
                                    dump('Error pago', $e->getMessage());
                                }
                            }
                        }
                    }

                    //dd($sources);
                }
            }
        }

        return 0;
    }
}


/*

CODIGO en customers

public function payments($customerId, array $parameters = [])
{
    return $this->_get("customers/{$customerId}/payment_methods", $parameters);
}

*/
