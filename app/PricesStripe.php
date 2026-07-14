<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricesStripe extends Model
{
    public const TYPE_OLDER = 0;
    public const TYPE_BASIC = 1;
    public const TYPE_LIFECOOLER = 2;
    public const TYPE_ENROLLMENT = 3;

    protected $table = 'prices_stripe';

    protected $fillable = ['course_id', 'interval_recurring'];
}
