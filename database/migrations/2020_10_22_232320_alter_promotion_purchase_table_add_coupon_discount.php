<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionPurchaseTableAddCouponDiscount extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'promotion_purchase';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->decimal('gross_price', 10,2)->after('stripe_charge_token')->nullable()->default(null);
            $table->decimal('discount', 10,2)->after('gross_price')->nullable()->default(null);
            $table->integer('coupon_id')->after('discount')->unsigned()->nullable()->index();
            $table->decimal('coupon_discount', 10,2)->after('coupon_id')->nullable()->default(null);
      //      $table->decimal('sub_total', 10,2)->after('coupon_discount')->nullable()->default(null);
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'coupon_discount')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['coupon_discount','discount','gross_price']);
              //  $table->dropForeign(['coupon_id']);
            });
        }
    }
}
