<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanPurchaseFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('promotion_purchase', 'payment_method')) {
            Schema::table('promotion_purchase', function (Blueprint $table) {
                if (DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign(['coupon_id']);
                }
                $table->dropColumn(['payment_method','stripe_charge_token','stripe_customer_token','stripe_payment_intent_token',
                    'gross_price','discount','coupon_id','coupon_discount','total_price','currency','payment_status','payment_status_error']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
