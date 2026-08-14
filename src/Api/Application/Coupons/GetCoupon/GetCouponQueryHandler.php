<?php

namespace Mi-empresa\Api\Application\Coupons\GetCoupon;

use App\Exceptions\CouponException;
use Mi-empresa\Api\Domain\Repository\CouponRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetCouponQueryHandler implements QueryHandler
{
    public function __construct(
        private CouponRepository $couponRepository
    ) {
    }

    public function __invoke(GetCouponQuery $getCouponQuery): ?\App\Coupon
    {
        $coupon = $this->couponRepository->getByCode(
            $getCouponQuery->promoCode(),
            $getCouponQuery->typeCoupon()
        );

        if (isset($coupon->course_id) && !empty($getCouponQuery->courseId())) {
            if ($coupon->course_id !== $getCouponQuery->courseId()->value()) {
                throw new CouponException('El cupón no se puede usar en este curso');
            }
        }
        return $coupon;
    }
}
