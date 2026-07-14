<?php

namespace Lifecole\Api\Application\Coupons\GetCoupon;

use Lifecole\Event\Domain\Bus\Query\Query;
use Lifecole\Shared\Domain\ValueObject\CourseId;

class GetCouponQuery extends Query
{
    public function __construct(
        private string $promoCode,
        private int $typeCoupon,
        private CourseId $courseId
    ) {
        parent::__construct();
    }

    public function promoCode(): string
    {
        return $this->promoCode;
    }

    public function typeCoupon(): int
    {
        return $this->typeCoupon;
    }

    public function courseId(): CourseId
    {
        return $this->courseId;
    }
}
