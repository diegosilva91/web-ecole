<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSent extends Model
{
    public const REMINDER_PROMOTION_NEW_USERS_5_DAYS = 1;
    public const REMINDER_PROMOTION_NEW_USERS_10_DAYS = 2;
    public const REMINDER_PROMOTION_NEW_USERS_15_DAYS = 3;
    public const FAILED_PAYMENT_NOTICE = 4;

    protected $table = 'mail_sent';

    protected $fillable = ['user_id','sender_id','object_type','object_id','subject','content','type'];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
