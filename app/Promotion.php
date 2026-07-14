<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'promotions';

    protected $fillable = ['course_id', 'start_at', 'end_at', 'updated_at', 'created_at', 'daily'];

    /*protected $casts = [
        'daily' => 'array',
    ];*/

    public function course()
    {
        return $this->belongsTo("App\Course", 'course_id', 'id');
    }

    public function courses()
    {
        return $this->hasOne("App\Course", 'id', 'course_id');
    }

    public function promotionPurchase(): Collection
    {
        return $this->hasMany("App\PromotionPurchase", 'promotion_id')->get();
    }

    /**
     * With Success
     * @return HasMany
     */
    public function promotionPurchases(): HasMany
    {
        return $this->hasMany("App\PromotionPurchase", 'promotion_id')->where(function ($query) {
            $query->where('paid', '=', PromotionPurchase::PAID_PAID);
        });
    }

    public function promotionPurchasesAll(): HasMany
    {
        return $this->hasMany("App\PromotionPurchase", 'promotion_id');
    }

    /**
     * @return HasManyThrough
     */
    public function usersPromotionPurchases(): HasManyThrough
    {
        return $this->hasManyThrough("App\User", "App\PromotionPurchase", 'promotion_id', 'id', 'id', 'user_id')->where(function ($query) {
            $query->where('paid', '=', PromotionPurchase::PAID_PAID);
        });
    }

    /**
     * @return HasOneThrough
     */
    public function userPromotionPurchases(): HasOneThrough
    {
        return $this->hasOneThrough("App\User", "App\PromotionPurchase", 'promotion_id', 'id', 'id', 'user_id')->where(function ($query) {
            $query->where('paid', '=', PromotionPurchase::PAID_PAID);
        });
    }

    public function user()
    {
        return $this->hasOneThrough("App\User", 'App\CourseUsers', 'course_id', 'id', 'course_id', 'user_id');
    }

    public function userAssistant()
    {
        return $this->hasManyThrough("App\UserAssistant", "App\PromotionPurchase", 'promotion_id', 'user_id', 'id', 'user_id')->where(function ($query) {
            $query->where('paid', '=', PromotionPurchase::PAID_PAID);
        });
    }

    /********************/
    /*******SCOPES******/
    /*******************/
    public function scopeCountPromotion($query, $promotion_id)
    {
        return $query->where("promotions.id", $promotion_id)->count();
    }

    public function scopeStartsAfter($query, $date1, $date2)
    {
        //return $query->where('start_at','>=', $date1);
        return $query->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')->orderBy('start_at')->whereBetween('start_at', [$date1, $date2]);
        //return $query->whereHas('promotions',function(Builder $query)use($date){ $query->selectRaw('MIN(start_at) as start_at')->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')->where('start_at', '<=', Carbon::parse($date));});
    }

    public function scopeStartsAfterHour($query, $hour1, $hour2)
    {
        return $query->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')->orderBy('start_at')->whereTime('start_at', '>=', $hour1)->whereTime('start_at', '<=', $hour2);
    }

    public function scopeActivePromotions($query, $active)
    {
        $now = now();
        //$now = new \DateTime('2022-04-01 20:30:00');
        switch ($now->format('N')) {
            case '6';
                $now->add(\DateInterval::createFromDateString('3 day'));
                $now->setTime(0, 0, 0);
                break;
            case '7';
                $now->add(\DateInterval::createFromDateString('2 day'));
                $now->setTime(0, 0, 0);
                break;
            default:
                $now->add(\DateInterval::createFromDateString('1 day'));
        }

        if (isset($active)) {
            if ($active === 'true' || $active === true) {
                return $query->where('start_at', '>', $now->format('Y-m-d H:i:s'))->orderBy('start_at', 'asc');
            } else {
                return $query->orderBy('start_at', 'desc');
            }
        }
        return $query->where('start_at', '>', $now->format('Y-m-d H:i:s'))->orderBy('start_at', 'asc');
    }

    public function scopeStartAtEndAt($query, $case)
    {
        switch ($case) {
            case 'all':
                return $query->orderBy('start_at', 'desc');
                break;
            case 'next':
                return $query->orderBy('start_at')->where('start_at', '>', now()->format('Y-m-d'))->where('end_at', '>', now()->format('Y-m-d'));
                break;
            case 'finished':
                return $query->orderBy('start_at')->where('start_at', '<', now()->format('Y-m-d'))->where('end_at', '<', now()->format('Y-m-d'));
                break;
            case 'active':
            default:
                return $query->orderBy('start_at')->where('start_at', '<', now()->format('Y-m-d'))->where('end_at', '>', now()->format('Y-m-d'));
        }
    }

    public function scopeIsPurchasable($query, $condition)
    {
        if (isset($condition)) {
            if ($condition === 'true' || $condition === true) {
                return $query->where('start_at', '>=', now()->addDay());
            }
            return $query;
        }
        return $query;
    }
}
