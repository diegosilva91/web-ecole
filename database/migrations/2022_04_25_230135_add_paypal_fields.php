<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'paypal_payer_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('paypal_payer_id')->after('stripe_id')->default(null)->nullable()->index()->unique();
            });
        }
        if (!Schema::hasColumn('promotion_purchase_payment', 'paypal_order_id')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->string('paypal_order_id')->after('stripe_transaction_token')->default(null)->nullable();
            });
        }
        if (!Schema::hasColumn('promotion_purchase_payment', 'paypal_transaction_id')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->string('paypal_transaction_id')->after('stripe_transaction_token')->default(null)->nullable()->index()->unique();
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
        if (Schema::hasColumn('users', 'paypal_payer_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['paypal_payer_id']);
            });
        }
        if (Schema::hasColumn('promotion_purchase_payment', 'order_id')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->dropColumn(['order_id']);
            });
        }
        if (Schema::hasColumn('promotion_purchase_payment', 'paypal_transaction_id')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->dropColumn(['paypal_transaction_id']);
            });
        }
    }
}
