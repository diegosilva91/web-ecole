<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteStripeChargeToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('promotion_purchase_payment', 'stripe_charge_token')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->dropColumn(['stripe_charge_token']);
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
        Schema::table('promotion_purchase_payment', function (Blueprint $table) {
            $table->string('stripe_charge_token', 40)->after('stripe_customer_token')->nullable()->default(null);
        });
    }
}
