<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionPurchasePayment extends Model
{
    public const PROVIDER_UNDEFINED = 0;
    public const PROVIDER_TRANSFER = 1;
    public const PROVIDER_STRIPE = 2;
    public const PROVIDER_PAYPAL = 3;

    protected $table = 'promotion_purchase_payment';
    protected $fillable = [
        'promotion_purchase_id',
        'provider', 'payment_method',
        'total_price','gross_price', 'discount', 'coupon_discount', 'coupon_id','currency',
        'payment_status', 'payment_status_error', 'paid_at',
        'period_start', 'period_end',
        'stripe_customer_token', 'stripe_payment_intent_token',
        'stripe_subscription_token'
    ];

    public function promotionPurchase(): PromotionPurchase
    {
        return $this->hasOne("App\PromotionPurchase", 'id', 'promotion_purchase_id')->get()->first();
    }

    public function coupon()
    {
        return $this->hasOne("App\Coupon", 'id', 'coupon_id')->first();
    }

    public function scopeFilterByField($query, $field, $status)
    {
        return $query->where($field, $status);
    }
}
