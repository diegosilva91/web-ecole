<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public const TYPE_INTENSIVE = 1;
    public const TYPE_TRAJECTORY = 2;

    protected $fillable = ['type', 'counter', 'code', 'owner_id', 'limit', 'name', 'description', 'is_active', 'expire_at'];

    public static function findByCode($code)
    {
        return self::where('code', $code);
    }

    public function getDiscount($total)
    {
        if ($this->type == 'fixed') {
            return $this->discount;
        } elseif ($this->type == 'percent') {
            return ($this->discount / 100) * $total;
        } elseif ($this->type == 'price') {
            return $total - $this->discount;
        } else {
            return 0;
        }
    }
}
