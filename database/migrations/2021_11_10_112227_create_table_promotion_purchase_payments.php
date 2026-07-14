<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePromotionPurchasePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_purchase_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('promotion_purchase_id')->unsigned()->nullable()->default(null);

            $table->tinyInteger('provider');
            $table->string('payment_method', 155)->nullable()->default(null);
            $table->decimal('gross_price', 10, 2)->nullable()->default(null);
            $table->decimal('discount', 10, 2)->nullable()->default(null);
            $table->integer('coupon_id')->unsigned()->nullable()->index();
            $table->decimal('coupon_discount', 10, 2)->nullable()->default(null);
            $table->decimal('total_price', 10, 2)->nullable()->default(null);
            $table->string('currency', 15)->nullable()->default(null);
            $table->string('payment_status', 55)->nullable()->default(null);
            $table->string('payment_status_error')->nullable()->default(null);
            $table->timestamp('period_start')->nullable()->default(null);
            $table->timestamp('period_end')->nullable()->default(null);
            $table->string('stripe_customer_token')->nullable()->default(null);
            $table->string('stripe_charge_token')->nullable()->default(null);
            $table->string('stripe_payment_intent_token', 191)->nullable();

            $table->foreign('promotion_purchase_id')->references('id')->on('promotion_purchase')->onDelete('restrict');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('restrict');
            $table->timestamps();
        });

        Schema::table('promotion_purchase', function ($table) {
            $table->tinyInteger('paid');
            $table->tinyInteger('active');
            $table->tinyInteger('type_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_purchase_payment');
    }
}
