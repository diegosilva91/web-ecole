<?php

namespace App\Http\Controllers\Subscriptions;

use App\Coupon;
use App\Course;
use App\Http\Controllers\Controller;
use App\PricesStripe;
use App\Promotion;
use App\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Mi-empresa\Api\Application\Coupons\GetCoupon\GetCouponQuery;
use Mi-empresa\Api\Domain\Repository\StripePaymentsRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;

class TrajectoriesController extends Controller
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function landingTrajectories()
    {
        return view('pages.trajectories');
    }

    public function trajectoriesAll()
    {
        $parameters['type_course'] = Course::TYPE_TRAJECTORY;
        $request = Request::create(route('courses.list', $parameters));

        return Response::make(app('App\Http\Controllers\Web\Courses\CoursesController')->courses($request));
    }

    public function paymentTrajectoriesPreView($course_id, $pack_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            abort(404, 'Page not found');
        }
        $user = Auth::user();
        if (Auth::check()) {
            $user->load('UserAssistant');
            //Log::info('User in payment load ' . $user->email);
        }

        if ($course->is_subscription === 1) {
            $course->load('pricesPacks');
        }
        $dataSubscription = $this->getDataSubscription($course_id, $pack_id);
        return view('pages.payment-trajectories', [
            'pack_id' => (int)$pack_id,
            'user' => $user,
            'promotion' => null,
            'course' => $course,
            'coupon' => $dataSubscription['coupon'],
            'price_subscription' => $dataSubscription['price_subscription'],
            'price_enrollment' => $dataSubscription['price_enrollment'],
        ]);
    }

    public function paymentTrajectoriesView($course_id, $pack_id, $promotion_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            abort(404, 'Page not found');
        }
        $promotion = Promotion::find($promotion_id);
        if (!$promotion) {
            abort(404, 'Page not found');
        }
        if ($course->is_subscription === 1) {
            $course->load('pricesPacks');
        }
        $user = Auth::user();
        if (Auth::check()) {
            $user->load('UserAssistant');
            //Log::info('User in payment load ' . $user->email);
        }

        $course->promotions()->IsPurchasable(true)->ActivePromotions(true)->get();
        $dataSubscription = $this->getDataSubscription($course_id, $pack_id);

        return view('pages.payment-trajectories', [
            'pack_id' => (int)$pack_id,
            'user' => $user,
            'promotion' => $promotion,
            'course' => $course,
            'coupon' => $dataSubscription['coupon'],
            'price_subscription' => $dataSubscription['price_subscription'],
            'price_enrollment' => $dataSubscription['price_enrollment'],
        ]);
    }

    private function getDataSubscription($course_id, $pack_id)
    {
        $course = Course::with(['pricesPacks', 'pricesEnrollment' => function ($query) {
            $query->where('is_active', true);
        }])
            ->where('id', $course_id)->first();
//        dd($course);
        $price_subscription = null;
        $price_enrollment = null;

//        $this->queryBus->ask(new GetPricesStripeQuery(null, []));
        $price_subscription = match ((int)$pack_id) {
            default => $course->prices->where('prices_id_stripe_old', '<>', null)->where('model_type', '=', (int)$pack_id)->first(),
            PricesStripe::TYPE_BASIC => $course->prices->
            where('prices_id_stripe_basic', '<>', null)->where('model_type', '=', (int)$pack_id)->first(),
            PricesStripe::TYPE_LIFECOOLER => $course->prices->
            where('prices_id_stripe_lifecooler', '<>', null)->where('model_type', '=', (int)$pack_id)->first(),
        };

        if (count($course->pricesEnrollment) > 0) {
            $course->price_total = $course->price_total + $course->pricesEnrollment->first()->price_subscription;
            $price_subscription = $course->prices->first();
            $price_enrollment = $course->pricesEnrollment->first();
        }
        if (empty($price_subscription)) {
            $price_subscription = $course->prices->first();
            //need to create price
        }
        $coupon_name = '';
        return [
            'coupon' => $coupon_name,
            'price_subscription' => $price_subscription,
            'price_enrollment' => $price_enrollment
        ];
    }

    public function createSubscription(Request $request, StripePaymentsRepository $stripePaymentsRepository): JsonResponse
    {
        if ($request->has('course_id') && isset($request->promotion_id) && $request->has('price_id')) {
            $course = Course::find($request->get('course_id'));
            $promotion = Promotion::find($request->promotion_id);
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
                    $customerUser->stripe_id = $customer['id'];
                    $customerUser->save();
                }

                $prices = [0 => [
                    'price' => $request->get('price_id')
                ]];
                if ($request->get('price_enrollment_id')) {
                    array_push($prices, [
                        'price' => $request->get('price_enrollment_id')
                    ]);
                }
                $metadata = [
                    'course_id' => $course->id,
                    'course_title' => $course->title,
                    'course_link' => $course->getLink(),
                    'user_mail' => $request->email,
                    'promotion_id' => $promotion->id,
                    'promotion_date' => $promotion->start_at,
                ];
                $promo_code = $request->get('promo_code');
                if (isset($promo_code)) {
                    $provider = $request->get('provider', Coupon::TYPE_TRAJECTORY);
                    $coupon = $this->queryBus->ask(new GetCouponQuery($promo_code, $provider, CourseId::create($course->id)));
                    if (isset($coupon)) {
                        $metadata += ['coupon_code' => $coupon->code,
                            'coupon_type' => $coupon->type,
                            'coupon_discount' => $coupon->discount
                        ];
                    } else {
                        $promo_code = null;
                    }
                }
                $subscription = Stripe::subscriptions()->create($customer_id, [
                    'items' => $prices,
                    'payment_behavior' => 'default_incomplete',
                    'proration_behavior' => 'none',
                    'expand' => ['latest_invoice.payment_intent'],
                    'customer' => $customer_id,
                    'coupon' => $promo_code,
                    'metadata' => $metadata
                ]);
//                dd($subscription,$intent,[
//                    'subscriptionId' => $subscription['id'],
//                    'clientSecret' => $subscription['latest_invoice']['payment_intent']['client_secret']
//                ]);
                return response()->json([
                    'id' => $subscription['latest_invoice']['payment_intent']['id'],
                    'customer' => $customer_id,
                    'subscriptionId' => $subscription['id'],
                    'client_secret' => $subscription['latest_invoice']['payment_intent']['client_secret']
                ], 201);
            } catch (\Exception $e) {
                //Log::error('Error creating subscription intent');
                return response()->json($e->getMessage(), 500);
            }
        }
        return response()->json('Empty', 500);
    }

    public function updateSubscription(Request $request, $id, StripePaymentsRepository $stripePaymentsRepository): JsonResponse
    {
        if ($request->has('course_id') && isset($request->promotion_id) && $request->has('price_id')) {
            $paymentIntent = Stripe::paymentIntents()->find($id);
            $invoice = Stripe::invoices()->find($paymentIntent['invoice']);
            $idSubscription = $invoice['subscription'];

            $course = Course::find($request->get('course_id'));
            $promotion = Promotion::find($request->promotion_id);
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
                    $customerUser->stripe_id = $customer['id'];
                    $customerUser->save();
                }

                $prices = [0 => [
                    'price' => $request->get('price_id')
                ]];
                if ($request->get('price_enrollment_id')) {
                    array_push($prices, [
                        'price' => $request->get('price_enrollment_id')
                    ]);
                }
                $metadata = [
                    'course_id' => $course->id,
                    'course_title' => $course->title,
                    'course_link' => $course->getLink(),
                    'user_mail' => $request->email,
                    'promotion_id' => $promotion->id,
                    'promotion_date' => $promotion->start_at,
                ];
                $promo_code = $request->get('promo_code');
                if (isset($promo_code)) {
                    $provider = $request->get('provider', Coupon::TYPE_TRAJECTORY);
                    $coupon = $this->queryBus->ask(new GetCouponQuery($promo_code, $provider, CourseId::create($course->id)));
                    if (isset($coupon)) {
                        $metadata += ['coupon_code' => $coupon->code,
                            'coupon_type' => $coupon->type,
                            'coupon_discount' => $coupon->discount
                        ];
                    } else {
                        $promo_code = null;
                    }
                }

                $subscription = Stripe::subscriptions()->update($customer_id, $idSubscription, [
                    'coupon' => $promo_code,
                    'metadata' => $metadata
                ]);
//                dd($subscription,$intent,[
//                    'subscriptionId' => $subscription['id'],
//                    'clientSecret' => $subscription['latest_invoice']['payment_intent']['client_secret']
//                ]);
                return response()->json([
                    'id' => $paymentIntent['id'],
                    'customer' => $customer_id,
                    'subscriptionId' => $subscription['id'],
                    'client_secret' => $paymentIntent['client_secret']
                ], 201);
            } catch (\Exception $e) {
                //Log::error('Error creating subscription intent');
                return response()->json($e->getMessage(), 500);
            }
        }
        return response()->json('Empty', 500);
    }
}
