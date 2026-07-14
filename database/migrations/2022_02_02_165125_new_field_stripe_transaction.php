<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFieldStripeTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_purchase_payment', function (Blueprint $table) {
            $table->string('stripe_customer_token', 40)->nullable()->default(null)->change();
            $table->string('stripe_charge_token', 40)->nullable()->default(null)->change();
            $table->string('stripe_payment_intent_token', 40)->nullable()->default(null)->change();
            $table->string('stripe_subscription_token', 40)->nullable()->default(null)->after('stripe_payment_intent_token');
            $table->string('stripe_transaction_token', 40)->nullable()->default(null)->after('stripe_subscription_token');
        });
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
