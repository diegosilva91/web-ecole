<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['user_id', 'provider_id', 'provider', 'notification_promotions','alternative_email', 'paypal_payer_id','stripe_id'];
}
