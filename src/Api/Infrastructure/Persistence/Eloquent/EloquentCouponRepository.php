<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\Coupon;
use Mi-empresa\Api\Domain\Repository\CouponRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCouponRepository extends EloquentRepository implements CouponRepository
{
    public function getByCode(string $code, int $type_coupon): ?Coupon
    {
        $this->model = $this->model::findByCode($code);
        return $this->getByColumn('type_coupon', $type_coupon)->getByColumn('is_active', 1)
            ->getByColumn('limit', 'counter+1', '>=')->getByColumn('expire_at', now(), '>=')
            ->retrieveFirstFromQuery();
    }

    protected function model(): string
    {
        return Coupon::class;
    }
}
