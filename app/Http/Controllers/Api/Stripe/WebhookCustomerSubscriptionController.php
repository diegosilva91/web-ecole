<?php

namespace App\Http\Controllers\Api\Stripe;

use App\Http\Controllers\Controller;
use App\Http\Requests\StripeRequest;
use App\Mail\Internal\ReportRequestError;
use App\PaymentsEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Lifecole\Api\Application\Payments\CustomerSubscriptionsStripeEventsManager\CustomerSubscriptionsStripeEventsManagerCommand;
use Lifecole\Api\Application\Payments\StorePayloadStripe\StorePayloadStripeCommand;
use Lifecole\Event\Domain\Bus\Command\CommandBus;

class WebhookCustomerSubscriptionController extends Controller
{
    public function __construct(private CommandBus $commandBus)
    {
    }

    public function webhookCustomerSubscriptions(StripeRequest $request): JsonResponse
    {
        if ($request->get('type') === 'customer.subscription.updated') {
            try {
                $this->commandBus->dispatch(
                    new CustomerSubscriptionsStripeEventsManagerCommand($request->get('data'))
                );

                $this->commandBus->dispatch(
                    new StorePayloadStripeCommand($request->all(), PaymentsEvent::STATUS_SUCCEEDED)
                );
            } catch (\Exception $e) {
                Mail::send(new ReportRequestError(url()->current(), $request, $e));
                return response()->json('Invalid state subscription to change', 422);
            }
        } else {
            $this->commandBus->dispatch(
                new StorePayloadStripeCommand($request->all(), PaymentsEvent::STATUS_IGNORED)
            );
        }

        return response()->json('E', 204);
    }
}
