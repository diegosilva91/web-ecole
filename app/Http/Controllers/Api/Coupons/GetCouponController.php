<?php

namespace App\Http\Controllers\Api\Coupons;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromoCodeRequest;
use Mi-empresa\Api\Application\Coupons\GetCoupon\GetCouponQuery;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;

class GetCouponController extends Controller
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function getPromoCode($code, PromoCodeRequest $request)
    {
        $course_id = $request->get('course_id');
        $type_coupon = $request->get('type_coupon', Coupon::TYPE_INTENSIVE);
        try {
            $promo_code = $this->queryBus->ask(new GetCouponQuery($code, $type_coupon, CourseId::create($course_id)));
            return response()->json([ 'promo_code' => $promo_code ]);
        } catch (\Exception $exception) {
            return response()->json([ 'error' => $exception->getMessage() ]);
        }
    }
}
