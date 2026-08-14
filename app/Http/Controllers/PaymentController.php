<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Course;
use App\Mail\Internal\ReportRequestError;
use App\Promotion;
use App\PromotionPurchase;
use App\PromotionPurchaseAssistant;
use App\PromotionPurchasePayment;
use App\User;
use App\UserAssistant;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mi-empresa\Api\Application\Coupons\GetCoupon\GetCouponQuery;
use Mi-empresa\Api\Application\Payments\ConfirmationPaymentOrderCommand\ConfirmationPaymentOrderCommand;
use Mi-empresa\Api\Application\Payments\ConfirmationPurchaseOrderCommand\ConfirmationPurchaseOrderCommand;
use Mi-empresa\Api\Application\Paypal\UpdatePaymentPaypalCommand;
use Mi-empresa\Api\Domain\DTO\PaypalPayment;
use Mi-empresa\Api\Domain\Repository\StripePaymentsRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;
use Mi-empresa\Event\Domain\Bus\Event\EventBus;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Event\Domain\Purchase\PurchaseWasCompleted;
use Mi-empresa\Shared\Domain\Event\CustomerWasCreated;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;

class PaymentController extends Controller
{
    public function __construct(private QueryBus $queryBus, private CommandBus $commandBus)
    {
    }

    public function payout(Request $request): JsonResponse|RedirectResponse
    {
        // 1. Validate data format

        $promotion_id = (int)$request->promotion_id;

        if (!$promotion_id) {
            abort(404, 'Page not found');
        }

        $promotion = Promotion::find($promotion_id);
        if (!$promotion) {
            abort(404, 'Page not found');
        }
        $niceMessages = [
            'name' => 'nombre',
            'assistant_name[0]' => 'nombre del hij@',
            'assistant_age[0]' => 'edad del hij@',
            'email' => 'correo electrónico',
            'phone' => 'teléfono'
            //    'card_number' => 'número de tarjeta',
            //    'card_exp_month' => ['mes de caducidad'],
            //    'card_exp_year' => ['año de caducidad'],
        ];
        $messages = [
            'same' => 'El campo :attribute y :other deben ser iguales',
            'size' => 'El campo :attribute debe ser de :size.',
            'between' => 'El valor :input del campo :attribute no se encuentra entre :min - :max.',
            'in' => 'El campo :attribute debe ser uno de los siguiente tipos: :values',
            'min' => 'El campo :attribute debe tener al menos :min',
            'required' => 'Introduce el :attribute válido',
            'assistant_name[0].max' => 'El campo :attribute debe tener más de 255 carácteres',
            'assistant_age[0].min' => 'El campo :attribute debe ser mayor de 4 años',
        ];

        if (Auth::check()) {
            if ($request->add_son == 'new') {
                $validator_fields = [
                    'assistant_name[0]' => ['required', 'string', 'max:255'],
                    'assistant_age[0]' => ['required', 'integer', 'min:0', 'max:100'],
                ];
            } else {
                $validator_fields = [
                ];
            }
        } else {
            $validator_fields = ['name' => ['required', 'string', 'min:1', 'max:255'],
                'assistant_name[0]' => ['required', 'string', 'max:255'],
                'assistant_age[0]' => ['required', 'integer', 'min:0', 'max:100'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['required', 'regex:/^(1[ \-\+]{0,3}|\+1[ -\+]{0,3}|\+1|\+)?((\(\+?1-[2-9][0-9]{1,2}\))|(\(\+?[2-8][0-9][0-9]\))|(\(\+?[1-9][0-9]\))|(\(\+?[17]\))|(\([2-9][2-9]\))|([ \-\.]{0,3}[0-9]{2,4}))?([ \-\.][0-9])?([ \-\.]{0,3}[0-9]{2,4}){2,3}$/']
            ];
        }
        $validator = Validator::make($request->all(), $validator_fields, $messages, $niceMessages);

        if ($validator->fails()) {
            Log::info($validator->errors());
            return $request->wantsJson()
                ? new JsonResponse(['status' => 'error',
                    'errors' => ($validator->errors())
                ], 422)
                : Redirect::back()->withErrors($validator)->withInput();
        }

        // 2. Check if user exist

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'type_user' => User::CUSTOMER,
                'phone' => $request->phone
            ]);

            if (!$user->customer()->exists()) {
                $customer = $user->customer()->create();
            }
            try {
                event(new CustomerWasCreated($user));
            } catch (\Exception $error) {
                Log::error($error);
            }
        }

        if ($user->hasRole('admin') || $user->hasRole('teacher')) {
            $profileDescription = $user->hasRole('admin') ? 'Administrador' : 'Profesor';
            $validator
                ->errors()->add('payment', "No es posible realizar una compra con un perfil de $profileDescription");
            Log::info('Payment, it is not a customer ' . $user->email);
            return $request->wantsJson()
                ? new JsonResponse(['status' => 'error',
                    'errors' => ($validator->errors())
                ], 422)
                : Redirect::back()->withErrors($validator)->withInput();
        }

        Log::info('User in payment ' . $user->email);
        if ($user->id !== Auth::id() && !Auth::check()) {
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                $validator
                    ->errors()->add('payment', "El usuario <b>" . $request->email . "</b> ya dispone de una cuenta en Mi-empresa, por favor <a data-toggle='modal' data-target='#Login' class='v-application&quot;&quot;'>haz login aqui</a> para continuar tu compra.");
                Log::info('Payment, wrong credentials for' . $user->email);
                return $request->wantsJson()
                    ? new JsonResponse(['status' => 'error',
                        'errors' => ($validator->errors())
                    ], 422)
                    : Redirect::back()->withErrors($validator)->withInput();
            }
        }

        $user->phone = $request->phone;
        $user->save();

        //3. Check if add_son checkbox is on to add other son, else continue

        $add_son = $request->add_son;
        if ($add_son == 'new' && (empty($request->input('assistant_name[0]')) || empty($request->input('assistant_age[0]')))) {
            Log::info('Assitant emtpy for ' . $user->mail);
            $validator
                ->errors()->add('assistant_name[0]', 'Es obligatorio asignar el curso por lo menos a un hijo');
            return $request->wantsJson()
                ? new JsonResponse(['status' => 'error',
                    'errors' => ($validator->errors())
                ], 422)
                : Redirect::back()->withErrors($validator)->withInput();
        } else if ($add_son == 'new' && !empty($request->input('assistant_name[0]')) && !empty($request->input('assistant_age[0]'))) {
            $userAssistant = UserAssistant::create([
                'age' => (int)$request->input('assistant_age[0]'),
                'name' => $request->input('assistant_name[0]'),
                'user_id' => $user->id
            ]);
            $userAssistant = [$userAssistant];
        } else {
            $userAssistant = \App\UserAssistant::where('id', $add_son)->get();
            // TODO; Check if $userAssistant belong to Auth:user
        }

        if (!$userAssistant) {
            $userAssistant = \App\UserAssistant::where('user_id', $user->id)->get();
        }

        if (!$userAssistant) {
            $validator
                ->errors()->add('assistant_name.[0]', 'Es obligatorio asignar el curso a un hijo');
            //return Redirect::back()->withErrors($validator)->withInput();
            Log::info('Payment, es necesario asinar un hijo');
            return $request->wantsJson()
                ? new JsonResponse(['status' => 'error',
                    'errors' => ($validator->errors())
                ], 422)
                : Redirect::back()->withErrors($validator)->withInput();
        }

        $course = Course::where('id', $promotion->course_id)->first();

        // 4. Create promotion purchase

        $promotionPurchase = PromotionPurchase::create([
            'promotion_id' => $promotion->id,
            'user_id' => $user->id,
            'paid' => PromotionPurchase::PAID_PENDING,
            'active' => PromotionPurchase::ACTIVE_NO,
            'type_payment' => ($course->is_subscription == '1') ? PromotionPurchase::PAYMENT_MONTHLY : PromotionPurchase::PAYMENT_UNIQUE,
        ]);

        if ($course->is_subscription) {
            $promotionPurchase->type_pack = $request->get('pack_id');
        }
        // 5. Validate Coupons and discounts

        $discount = null;
        $coupon_discount = null;
        $total_price = number_format($course->price_total, 0, '.', '');
        $coupon_id = null;

        if (isset($course->discount)) {
            $discount = number_format($course->price_total * ($course->discount / 100), 2, '.', '');
            $total_price = $course->price_total - $discount;
        }
        $promo_code = $request->get('promo_code');
        if (isset($promo_code)) {
            $provider = ($course->is_subscription == '1') ? Coupon::TYPE_TRAJECTORY : Coupon::TYPE_INTENSIVE;
            $coupon = $this->queryBus->ask(new GetCouponQuery($promo_code, $provider, CourseId::create($course->id)));
            if (isset($coupon)) {
                $coupon_discount = number_format($coupon->getDiscount($total_price), 2, '.', '');
                $coupon_id = $coupon->id;
                $total_price = $total_price - $coupon_discount;
            }
            //dd($coupon,$course->price_total,$total_price,$coupon_discount,$discount);
        }

        $promotionPurchase->save();

        // 6. Payment

        if ($course->is_subscription == '1') {
            $period_start = $promotion->start_at;
            $period_end = Carbon::parse($promotion->start_at)->endOfMonth()->endOfDay();
        } else {
            $period_start = $promotion->start_at;
            $period_end = $promotion->end_at;
        }

        $payment_method = $request->get('payment_method', 'Credit/Debit card');
        $provider = PromotionPurchasePayment::PROVIDER_STRIPE;
        if ($payment_method == 'transfer') {
            $provider = PromotionPurchasePayment::PROVIDER_TRANSFER;
        } else if ($payment_method == 'paypal') {
            $provider = PromotionPurchasePayment::PROVIDER_PAYPAL;
        }
        $promotionPurchasePayment = PromotionPurchasePayment::create([
            'promotion_purchase_id' => $promotionPurchase->id,
            'payment_method' => $payment_method,
            'provider' => $provider,
            'total_price' => $total_price,
            'gross_price' => $course->price_total,
            'discount' => $discount,
            'coupon_discount' => $coupon_discount,
            'coupon_id' => $coupon_id,
            'currency' => 'eur',
            'payment_status' => $request->get('payment_status', 'created'),
            'period_start' => $period_start,
            'period_end' => $period_end,
        ]);

        // 7. Assistants

        foreach ($userAssistant as $item) {
            $promotionPurchaseAssitants[] = PromotionPurchaseAssistant::create([
                'promotion_purchase_id' => $promotionPurchase->id,
                'user_assistant_id' => $item->id
            ]);
        }

        if ($promotionPurchase && $promotionPurchasePayment) {
            if (isset($request->secret_intent)) {
                try {
                    $metadata_coupon = [
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'course_link' => $course->getLink(),
                        'user_id' => $user->id,
                        'user_mail' => $user->email,
                        'promotion_id' => $promotion->id,
                        'promotion_purchase_id' => $promotionPurchase->id,
                        'promotion_date' => $promotion->start_at,
                        'assistants' => count($promotionPurchaseAssitants),
                        'discount' => $discount,
                        'gross_price' => $promotionPurchasePayment->gross_price,
                    ];
                    if (isset($coupon)) {
                        $coupon->save();
                        $metadata_coupon += ['coupon_code' => $coupon->code,
                            'coupon_type' => $coupon->type,
                            'coupon_discount' => $coupon_discount,
                            'paid' => 'pending'
                        ];
                    }
                    $paymentIntent = Stripe::paymentIntents()->update($request->secret_intent, [
                        'metadata' => $metadata_coupon,
                        'amount' => $total_price
                    ]);
                    return new JsonResponse([
                        'promotionPurchase' => $promotionPurchase,
                        'promotionPurchasePayment' => $promotionPurchasePayment,
                        'payment_intent' => $paymentIntent
                    ], 200);

                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    $truncated_error = Str::limit($e->getMessage(), 180);

                    $promotionPurchasePayment->payment_status_error = $truncated_error;
                    $promotionPurchasePayment->save();

                    $paymentIntent = Stripe::paymentIntents()->find($request->secret_intent);

                    return new JsonResponse([
                        'promotionPurchase' => $promotionPurchase,
                        'promotionPurchasePayment' => $promotionPurchasePayment,
                        'payment_intent' => $paymentIntent
                    ], 200);
                }
            }

            return new JsonResponse([
                'login' => ['user' => User::with('teacherCourse')->find(Auth::id()), 'status' => 'success'],
                'promotionPurchase' => $promotionPurchase,
                'promotionPurchasePayment' => $promotionPurchasePayment,
            ], 200);

        } else {
            Log::error('Pago no procesado, error generado');
            $validator->errors()->add('payment', 'Pago no procesado, error generado ');
            return $request->wantsJson()
                ? new JsonResponse(['status' => 'error',
                    'errors' => ($validator->errors())
                ], 422)
                : Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function createPaymentIntent(Request $request, StripePaymentsRepository $stripePaymentsRepository): JsonResponse
    {
        if (isset($request->course_id) && isset($request->promotion_id)) {
            $course = Course::find($request->course_id);
            $promotion = Promotion::find($request->promotion_id);
            $price = $request->price_total_stripe ?? $course->price_total;

            try {
                $user = User::where('email', $request->email)->first();
                $customerUser = optional($user->customer())->first();
                if (!isset($customerUser)) {
                    $customerUser = $user->customer()->create([
                        'stripe_id' => $user->stripe_id
                    ]);
                }
                if (!isset($user->stripe_id)) {
                    $customer = $stripePaymentsRepository->getCustomer($request->email);
                    $user->stripe_id = $customer['id'];
                    $user->save();
                }
                $customer_id = $user->stripe_id;

                if (!isset($customerUser->stripe_id)) {
                    $customer = $stripePaymentsRepository->getCustomer($request->email);
                    $customerUser->stripe_id = $customer['id'];
                    $customerUser->save();
                }

                $paymentIntent = Stripe::paymentIntents()->create([
                    'amount' => $price,
                    'currency' => 'eur',
                    'payment_method_types' => [
                        'card', 'sepa_debit'
                    ],
                    'customer' => $customer_id,
                    'setup_future_usage' => 'on_session',
                    'metadata' => [
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'course_link' => $course->getLink(),
                        'user_mail' => $request->email,
                        'promotion_id' => $promotion->id,
                        'promotion_date' => $promotion->start_at,
                    ]
                ]);
                return response()->json($paymentIntent, 200);

            } catch (\Exception $e) {
                Log::error('Error creating payment intent');
                return response()->json($e->getMessage(), 500);
            }
        }

        return response()->json('Empty', 500);
    }

    public function updatePaymentIntent(Request $request, $id): JsonResponse
    {
        $paymentIntent = Stripe::paymentIntents()->find($id);
        if (isset($request->price_total_stripe)) {
            try {
                if ($paymentIntent['amount'] != $request->price_total_stripe) {
                    $paymentIntent = Stripe::paymentIntents()->update($id, [
                        'amount' => $request->price_total_stripe
                    ]);
                }
            } catch (\Exception $e) {
                $paymentIntent = Stripe::paymentIntents()->find($id);
                return response()->json($paymentIntent, 200);
            }
        }
        if (isset($request->email)) {
            try {
                if ($paymentIntent['email'] != $request->email) {
                    $paymentIntent = Stripe::paymentIntents()->update($id, [
                        'email' => $request->email
                    ]);
                }
            } catch (\Exception $e) {
                $paymentIntent = Stripe::paymentIntents()->find($id);
                return response()->json($paymentIntent);
            }
        }
        return response()->json($paymentIntent);
    }

    public function UpdatePayment(Request $request, CommandBus $commandBus, EventBus $eventBus): JsonResponse
    {
        // 1. Validate data format
        $promotion_purchase_status = $request->get('promotion_purchase_status');
        if (isset($request->promotion_purchase_id) && isset($request->paymentIntent)) {
            try {
                $promotionPurchase = PromotionPurchase::find($request->promotion_purchase_id);
                if (!$promotionPurchase) {
                    return response()->json('not found', 400);
                }
                $promotionPurchasePayment = PromotionPurchasePayment::where(['promotion_purchase_id' => $promotionPurchase->id])->first();
                $user = $promotionPurchase->user();
                if (isset($request->promotion_purchase_status) && isset($promotionPurchasePayment->payment_status)) {
                    $promotion_purchase_status = $request->get('promotion_purchase_status');
                    if ($promotion_purchase_status == 'succeeded') {
                        $promotionPurchase->paid = PromotionPurchase::PAID_PAID;
                        $promotionPurchase->active = PromotionPurchase::ACTIVE_YES;
                        $promotionPurchasePayment->paid_at = new \DateTime();
                    } else if ($promotion_purchase_status == 'pending') {
                        $promotionPurchase->paid = PromotionPurchase::PAID_PAID;
                        $promotionPurchase->active = PromotionPurchase::ACTIVE_YES;
                    }
                }
                $promotionPurchase->save();
                if (isset($request->promotion_purchase_status) && isset($promotionPurchasePayment->payment_status)) {
                    $promotionPurchasePayment->payment_status = $request->promotion_purchase_status;
                }

                $promotionPurchasePayment->provider = PromotionPurchasePayment::PROVIDER_STRIPE;
                $promotionPurchasePayment->save();

                $promotion = $promotionPurchase->promotion();
                $course = $promotion->course()->first();
                $promotionPurchaseAssitants = PromotionPurchaseAssistant::where(['promotion_purchase_id' => $promotionPurchase->id])->get();
                $coupon = Coupon::find($promotionPurchasePayment->coupon_id);

                if ($promotionPurchase->active == PromotionPurchase::ACTIVE_YES) {
                    $eventBus->notify(new PurchaseWasCompleted($promotionPurchase->id));
                }

            } catch (\Exception $e) {
                Log::info($e->getMessage());
                return response()->json($e->getMessage(), 500);
            }
            try {
                if (
                    $promotion_purchase_status == 'succeeded' ||
                    ($promotion_purchase_status === 'pending' && $promotionPurchasePayment->payment_method === 'Sepa')
                ) {
                    $commandBus->dispatch(
                        new ConfirmationPurchaseOrderCommand($promotionPurchasePayment)
                    );
                }

                if ($promotion_purchase_status == 'succeeded') {
                    $commandBus->dispatch(
                        new ConfirmationPaymentOrderCommand($promotionPurchasePayment)
                    );
                }
            } catch (\Exception $e) {
                $truncated_error = Str::limit($e->getMessage(), 80);

                $promotionPurchasePayment->payment_status_error = 'Pago procesado correctamente, estamos procesando el envio del email de su compra' . $truncated_error;
                $promotionPurchasePayment->stripe_customer_token = $request->stripe_customer;
                $promotionPurchasePayment->stripe_subscription_token = $request->get('stripe_subscription_token');
                $promotionPurchasePayment->stripe_payment_intent_token = $request->paymentIntent['id'] ?? null;
                if (empty($promotionPurchasePayment->stripe_subscription_token) && Arr::has($request->paymentIntent, 'subscriptionId')) {
                    $promotionPurchasePayment->stripe_subscription_token = $request->paymentIntent['subscriptionId'];
                }
                $promotionPurchasePayment->save();

                try {
                    Mail::send(new ReportRequestError(url()->current(), $request, $e));
                } catch (\Exception $e) {
                }

                try {
                    $metadata_coupon = [
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                        'course_link' => $course->getLink(),
                        'user_id' => $user->id,
                        'user_mail' => $user->email,
                        'promotion_id' => $promotion->id,
                        'promotion_purchase_id' => $promotionPurchase->id,
                        'promotion_date' => $promotion->start_at,
                        'assistants' => count($promotionPurchaseAssitants),
                        'discount' => $promotionPurchasePayment->discount,
                        'gross_price' => $promotionPurchasePayment->gross_price,
                    ];
                    if (isset($coupon)) {
                        $coupon->counter = $coupon->counter + 1;
                        $coupon->save();
                        $metadata_coupon += ['coupon_code' => $coupon->code,
                            'coupon_type' => $coupon->type,
                            'coupon_discount' => $promotionPurchasePayment->coupon_discount,
                            'paid' => 'succeeded'
                        ];
                    }
                    $paymentIntent = Stripe::paymentIntents()->update($request->paymentIntent['id'], [
                        'metadata' => $metadata_coupon,
                    ]);
                } catch (\Exception $e) {

                }
                Log::error($e->getMessage());
                return response()->json(['promotionPurchase' => $promotionPurchase, 'promotionPurchasePayment' => $promotionPurchasePayment, 'email' => 'failed'], 200);
            }
            try {
                if (isset($request->stripe_customer)) {
                    $customer = Stripe::customers()->update($request->stripe_customer, [
                        'email' => $user->email,
                    ]);

                    $promotionPurchasePayment->stripe_customer_token = $request->stripe_customer;
                    $promotionPurchasePayment->stripe_subscription_token = $request->get('stripe_subscription_token');
                    $promotionPurchasePayment->stripe_payment_intent_token = $request->paymentIntent['id'] ?? null;
                    if (empty($promotionPurchasePayment->stripe_subscription_token) && Arr::has($request->paymentIntent, 'subscriptionId')) {
                        $promotionPurchasePayment->stripe_subscription_token = $request->paymentIntent['subscriptionId'];
                    }
                    $promotionPurchasePayment->save();
                }
                if (isset($request->paymentIntent['id'])) {
                    try {
                        $metadata_coupon = [
                            'course_id' => $course->id,
                            'course_title' => $course->title,
                            'course_link' => $course->getLink(),
                            'user_id' => $user->id,
                            'user_mail' => $user->email,
                            'promotion_id' => $promotion->id,
                            'promotion_purchase_id' => $promotionPurchase->id,
                            'promotion_date' => $promotion->start_at,
                            'assistants' => count($promotionPurchaseAssitants),
                            'discount' => $promotionPurchasePayment->discount,
                            'gross_price' => $promotionPurchasePayment->gross_price,
                        ];
                        if (isset($coupon)) {
                            $coupon->counter = $coupon->counter + 1;
                            $coupon->save();
                            $metadata_coupon += ['coupon_code' => $coupon->code,
                                'coupon_type' => $coupon->type,
                                'coupon_discount' => $promotionPurchasePayment->coupon_discount,
                                'paid' => 'succeeded'
                            ];
                        }
                        $paymentIntent = Stripe::paymentIntents()->update($request->paymentIntent['id'], [
                            'metadata' => $metadata_coupon,
                        ]);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        $truncated_error = Str::limit($e->getMessage(), 180);

                        $promotionPurchasePayment->payment_status_error = $truncated_error;
                        $promotionPurchasePayment->save();

                        return new JsonResponse(['promotionPurchase' => $promotionPurchase, 'promotionPurchasePayment' => $promotionPurchasePayment, 'paymentIntent' => 'failed update'], 200);
                    }
                }
            } catch (\Exception $e) {
                $truncated_error = Str::limit($e->getMessage(), 180);

                $promotionPurchasePayment->payment_status_error = $truncated_error;
                $promotionPurchasePayment->save();
                Log::error($e->getMessage());
                return response()->json($e->getMessage(), 500);
            }

            if (isset($request->promotion_purchase_status) && $request->promotion_purchase_status !== 'error') {
                return response()->json(['promotionPurchase' => $promotionPurchase, 'promotionPurchasePayment' => $promotionPurchasePayment], 200);
            }
        }

        if (isset($request->promotion_purchase_status) && $request->promotion_purchase_status === 'error') {
            $promotionPurchase = PromotionPurchase::find($request->promotion_purchase_id);

            $promotionPurchasePayment = PromotionPurchasePayment::where(['promotion_purchase_id' => $promotionPurchase->id])->first();
            $promotionPurchasePayment->payment_status = 'error';
            $promotionPurchasePayment->payment_status_error = $request->promotion_purchase_status_reason ? Str::limit($request->promotion_purchase_status_reason, 180) : 'stripe error';
            $promotionPurchasePayment->save();

            return response()->json('stripe error');
        }

        return response()->json('undefined error', 500);
    }

    /**
     * Únicamente se usa para transferencias o paypal
     */
    public function UpdatePaymentNew(Request $request, CommandBus $commandBus, EventBus $eventBus, $promotion_purchase_id): JsonResponse
    {
        if (!$promotion_purchase_id) {
            return response()->json('Request Empty', 500);
        }

        $promotionPurchase = PromotionPurchase::find($promotion_purchase_id);
        $promotionPurchasePayment = $promotionPurchase->lastPromotionPurchasePayment();
        $coupon = Coupon::find(optional($promotionPurchasePayment)->coupon_id);

        if ($request->has('promotion_purchase_status')) {
            $promotion_purchase_status = $request->get('promotion_purchase_status');
            $promotionPurchasePayment->payment_status = $promotion_purchase_status;
            if ($promotion_purchase_status == 'succeeded') {
                $promotionPurchase->paid = PromotionPurchase::PAID_PAID;
                $promotionPurchase->active = PromotionPurchase::ACTIVE_YES;
                $promotionPurchasePayment->paid_at = new \DateTime();
            } else if ($promotion_purchase_status == 'pending') {
                $promotionPurchase->paid = PromotionPurchase::PAID_PAID;
                $promotionPurchase->active = PromotionPurchase::ACTIVE_YES;
            }
        }

        $promotionPurchasePayment->provider = PromotionPurchasePayment::PROVIDER_UNDEFINED;
        if (isset($request->payment_method)) {
            $promotionPurchasePayment->payment_method = $request->payment_method;

            if ($request->payment_method == 'transfer') {
                $promotionPurchasePayment->provider = PromotionPurchasePayment::PROVIDER_TRANSFER;
            } else if ($request->payment_method == 'paypal') {
                $promotionPurchasePayment->provider = PromotionPurchasePayment::PROVIDER_PAYPAL;
                $promotionPurchasePayment->paypal_order_id = $request->get('orderID');
                $this->commandBus->dispatch(new UpdatePaymentPaypalCommand(
                    PaypalPayment::createFromPayment(
                        $request->get('payerID'),
                        $request->get('payments_paypal')
                    ),
                    $promotionPurchasePayment
                ));
            }
        }

        $promotionPurchase->save();
        $promotionPurchasePayment->save();

        try {
            $commandBus->dispatch(
                new ConfirmationPurchaseOrderCommand($promotionPurchasePayment)
            );

            $commandBus->dispatch(
                new ConfirmationPaymentOrderCommand($promotionPurchasePayment)
            );

            if ($promotionPurchase->active == PromotionPurchase::ACTIVE_YES) {
                $eventBus->notify(new PurchaseWasCompleted($promotionPurchase->id));
            }

        } catch (\Exception $e) {
            $truncated_error = Str::limit($e->getMessage(), 80);

            $promotionPurchasePayment->payment_status_error = 'Pago procesado correctamente, estamos procesando el envio del email de su compra' . $truncated_error;
            $promotionPurchasePayment->save();
            Log::error($e->getMessage());
            return response()->json(['promotionPurchase' => $promotionPurchase, 'promotionPurchasePayment' => $promotionPurchasePayment, 'email' => 'failed'], 200);
        } finally {
            if (isset($coupon)) {
                $coupon->counter = $coupon->counter + 1;
                $coupon->save();
            }
        }

        return response()->json(['right promotionPurchase' => $promotionPurchase], 200);
    }

    public function logPayment(Request $request)
    {
        Log::info($request);
        return response()->json(['log']);
    }
}
