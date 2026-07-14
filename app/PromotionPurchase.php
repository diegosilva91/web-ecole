<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromotionPurchase extends Model
{
    public const PAID_PENDING = 0;
    public const PAID_PAID = 1;

    public const ACTIVE_NO = 0;
    public const ACTIVE_YES = 1;

    public const PAYMENT_UNIQUE = 1;
    public const PAYMENT_MONTHLY = 2;

    public const TYPE_OLDER = 0;
    public const TYPE_BASIC = 1;
    public const TYPE_LIFECOOLER = 2;

    protected $table = 'promotion_purchase';
    protected $fillable = ['promotion_id',
        'user_id',
        'type_payment', 'paid', 'active',
        'type_pack'
    ];

    public function user(): User
    {
        /** @var User $user */
        $user = $this->belongsTo('App\User', 'user_id')->first();
        return $user;
    }

    public function promotion(): Promotion
    {
        /** @var Promotion $promotion */
        $promotion = $this->belongsTo('App\Promotion', 'promotion_id')->withTrashed()->first();
        return $promotion;
    }

    public function lastPromotionPurchasePayment(): ?PromotionPurchasePayment
    {
        return $this->hasMany("App\PromotionPurchasePayment", 'promotion_purchase_id')->orderBy('created_at')->get()->first();
    }

    public function payments(): Collection
    {
        return $this->hasMany("App\PromotionPurchasePayment", 'promotion_purchase_id')->get();
    }

    /**
     * @return HasMany
     */
    public function promotionPurchaseAssistants(): HasMany
    {
        return $this->hasMany('App\PromotionPurchaseAssistant', 'promotion_purchase_id');
    }

    public function scopeFilterByField($query, $field, $status)
    {
        return $query->where($field, $status);
    }
}
