<?php

namespace App;

use Eloquent;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword as TraitCanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as InterfaceCanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string $email
 * @property string|null $username
 * @property string|null $avatar
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property integer|null $status
 * @property string|null $provider
 * @property string|null $provider_id
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property-read Collection|UserAssistant[] $UserAssistant
 * @property-read int|null $user_assistant_count
 * @property-read Collection|Coupon[] $coupons
 * @property-read int|null $coupons_count
 * @property mixed $locale
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Teacher|null $teachers
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereApiToken($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereCardBrand($value)
 * @method static Builder|User whereCardLastFour($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereProvider($value)
 * @method static Builder|User whereProviderId($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSettings($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereStripeId($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 */
class User extends Model implements AuthenticatableContract, InterfaceCanResetPassword
{
    public const CUSTOMER = 0;
    public const TEACHER = 1;
    public const ADMIN = 2;

    use Notifiable;
    use Authenticatable;
    use TraitCanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'provider', 'provider_id', 'birth', 'type_user',
        'notification_promotions', 'paypal_payer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        return $value ?? config('app.user.default_avatar', 'images/users/default.png');
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            if (!$model->customer()->exists()) {
                try {
                    $model->customer()->create();
                } catch (\Exception $exception) {
                    $model->customer()->create(['user_id' => $model->id]);
                }
            }
            $model->customer()->first()->notification_promotions = $model->notification_promotions;
        });
    }


    public function teacher()
    {
        return $this->hasOne("App\Teacher", 'user_id');
    }

    public function customer()
    {
        return $this->hasOne("App\Customer", 'user_id');
    }

    public function teacherCourse()
    {
        return $this->belongsToMany("App\Course", 'App\CourseUsers', 'user_id', 'course_id', 'id', 'id');
    }

    public function promotionPurchase(): HasMany
    {
        return $this->hasMany('App\PromotionPurchase', 'user_id');
    }

    public function promotionPurchaseALl(): HasMany
    {
        return $this->hasMany('App\PromotionPurchase', 'user_id');
    }

    public function mailSent(): HasMany
    {
        return $this->hasMany('App\MailSent', 'user_id');
    }

    public function scopeSumUserPromotionPurchase($query, $status)
    {
        return $query->withCount(['promotionPurchase' => function (Builder $query) use ($status) {
//            $query->selectRaw('*, SUM(promotion_purchase.total_price) as sum_total_price')/*->where('promotion_purchase.payment_status', '=', $status);*/
//
//            ->groupBy('promotion_purchase.total_price');//,'promotion_purchase.id','promotion_purchase.user_id','promotion_purchase.payment_status');
        }]);
    }

    /**
     * For teachers, join with promotions with courses table with pivot and pivot foreign key user_id
     * @return HasManyThrough
     */
    public function promotions(): hasManyThrough
    {
        return $this->hasManyThrough("App\Promotion", 'App\CourseUsers', 'user_id', 'course_id', 'id', 'id');
        //return $this->hasManyThrough("App\Promotion", 'App\Course', 'user_id', 'course_id', 'id', 'id');
    }

    public function scopeCountPromotionPurchase($query, $status)
    {
        return $query->withCount(['promotions as teacher_promotion_purchases_count' => function (Builder $query) use ($status) {
            $query->join('promotion_purchase', 'promotion_purchase.promotion_id', '=', 'promotions.id')->where('promotion_purchase.paid', '=', $status);
        }]);
    }

    public function CouponsPromotionsPromotionPurchase(): HasManyThrough
    {
        return $this->hasManyThrough('App\Coupon', 'App\PromotionPurchasePayment', 'coupon_id', 'owner_id', 'id', 'id');
    }

    public function favouritesCourses(): HasMany
    {
        return $this->hasMany('App\FavouritesCourses', 'user_id');
    }

    public function UserAssistant(): HasMany
    {
        return $this->hasMany("App\UserAssistant", "user_id");
    }

    public function coupons(): HasMany
    {
        return $this->hasMany('App\Coupon', 'owner_id', 'id');
    }

    public function getRememberToken(): ?string
    {
        if (!empty($this->getRememberTokenName())) {
            return $this->{$this->getRememberTokenName()};
        }
        return null;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (!empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

    /**
     * Substituye el método que proveia VoyagerUser
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        $roles = [];
        if ($this->type_user == self::CUSTOMER) {
            $roles[] = 'customer';
        } elseif ($this->type_user == self::TEACHER) {
            $roles[] = 'teacher';
        } elseif ($this->type_user == self::ADMIN) {
            $roles[] = 'admin';
        }

        foreach ((is_array($name) ? $name : [$name]) as $role) {
            if (in_array($role, $roles)) {
                return true;
            }
        }

        return false;
    }
}
