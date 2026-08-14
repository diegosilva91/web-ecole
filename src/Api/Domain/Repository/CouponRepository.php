<?php

namespace Mi-empresa\Api\Domain\Repository;

use App\Coupon;

interface CouponRepository
{
    public function getByCode(string $code, int $type_coupon): ?Coupon;
}
