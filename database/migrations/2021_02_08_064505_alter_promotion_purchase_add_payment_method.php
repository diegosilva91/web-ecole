<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionPurchaseAddPaymentMethod extends Migration
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
        //
        Schema::table($this->tableName, function ($table) {
            $table->engine = 'InnoDB';
            $table->string('payment_method', 155)->after('user_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'payment_method')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['payment_method']);
            });
        }
    }

}
