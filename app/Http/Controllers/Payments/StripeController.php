<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Mail\Internal\ReportRequestError;
use App\PaymentsEvent;
use App\Promotion;
use App\PromotionPurchasePayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mi-empresa\Api\Application\Payments\StorePayloadStripe\StorePayloadStripeCommand;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;

class StripeController extends Controller
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function webhookInvoices(Request $request): JsonResponse
    {
        if ($request->has(['data.object', 'data.object.billing_reason', 'data.object.status', 'data.object.charge', 'data.object.lines', 'type'])) {
            $request->validate([
                'data.object.object' => 'required|string|max:255',
                'data.object.billing_reason' => 'required|string|max:255',
                'data.object.status' => 'required|string|max:255',
                'data.object.customer_email' => 'required|email',
                'data.object.lines.data' => 'present|array',
                'type' => 'required|string|max:255',
            ]);

            $this->commandBus->dispatch(new StorePayloadStripeCommand($request->all()));

            if (empty($request->input('data.object.lines.data.*.description'))) {
                return response()->json('invoice has not description');
                //todo send mail and log
            }
            if (empty($request->input('data.object.charge'))) {
                return response()->json('invoice has not charge');
            }
            if ($request->input('type') !== 'invoice.paid') {
                return response()->json('type webhook is not invoice.paid');
            }
            if ($request->input('data.object.billing_reason') !== 'manual') {
                // TODO; verificar que se ha guardado el evento en base de datos
                return response()->json([], 204);
            }
            if ($request->input('data.object.status' !== 'succeeded')) {
                return response()->json('process is not succeeded');
            }
            $promotion_id = isset($request->input('data.object.lines')['data'][0]['description']) ? explode('=', $request->input('data.object.lines')['data'][0]['description']) : null;
            if (empty($promotion_id[1])) {
                return response()->json('Cannot get promotion_id from request');
            }

            $promotion = Promotion::find($promotion_id[1]);
            if (empty($promotion) || !($promotion instanceof Promotion)) {
                return response()->json('Promotion id not found');
            }

            Mail::send(new ReportRequestError(url()->current(), $request, new \Exception('Intento de crear un usuario para el evento: ' . $request->input('data.object.charge'))));
        }

        return response()->json('Stripe object undefined');
    }

    public function webhookPaymentIntents(Request $request): JsonResponse
    {
        /**
         * Falla cuando los pagos son las suscripciones mensuales
         * Hay que excluir los "confirmation_method": "automatic",?
         */
        if ($request->get('type') === 'payment_intent.succeeded') {
            $request->validate([
                'data.object.object' => 'required|string|max:255',
                'data.object.status' => 'required|string|max:255',
                'data.object.charges' => 'present',
                'data.object.customer' => 'required|string|max:255',
                'data.object.charges.data' => 'present|array',
                'data.object.charges.data.*.id' => 'required|string|max:255',
                'type' => 'required|string|max:255',
            ]);

            $data = $request->get('data');
            if (isset($data['object']['id']) && isset($data['object']['customer']) && isset($request->input('data.object.charges.data')[0]['id'])) {
                $promotionPurchasePayment = PromotionPurchasePayment::where([
                    'stripe_customer_token' => $data['object']['customer'],
                    'stripe_payment_intent_token' => $data['object']['id'],
                ])
                    ->whereNotIn('payment_status', ['failed','error'])
                    ->first();

                if (isset($promotionPurchasePayment)) {
                    $updated = false;
                    if (!isset($promotionPurchasePayment->stripe_transaction_token)) {
                        $promotionPurchasePayment->stripe_transaction_token = $request->input('data.object.charges.data')[0]['balance_transaction'];
                        $updated = true;
                    }

                    if ($updated) {
                        $promotionPurchasePayment->save();
                        return response()->json('update charge token');
                    } else {
                        return response()->json('Promotion was updated yet: ' . $promotionPurchasePayment->stripe_transaction_token);
                    }
                }

                Mail::send(new ReportRequestError(url()->current(), $request, new \Exception('No hemos encontrado el Payment para el evento: ' . $data['object']['id'] . ' y el customer ' . $data['object']['customer'])));
                return response()->json('Not payment found', 422);
            }

            Mail::send(new ReportRequestError(url()->current(), $request, new \Exception('No tenemos todos los datos necesarios del Payment para el evento: ' . $data['object']['id'])));
            return response()->json('Undefined data payment_intent and metadata, try with another event like charge succeeded', 422);
        } elseif ($request->get('type') === 'payment_intent.created') {
            return response()->json('payment intent created');
        } elseif ($request->get('type') === 'payment_intent.processing') {
            $this->commandBus->dispatch(
                new StorePayloadStripeCommand($request->all(), PaymentsEvent::STATUS_PENDING)
            );
            return response()->json('payment intent processing stored');
        }

        return response()->json('Event diff succeeded');
    }

    public function webhookCharge(Request $request): JsonResponse
    {
        $this->commandBus->dispatch(
            new StorePayloadStripeCommand($request->all(), PaymentsEvent::STATUS_PENDING)
        );
        return response()->json('E', 204);
    }
}
