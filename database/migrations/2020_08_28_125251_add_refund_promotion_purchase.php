<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundPromotionPurchase extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'promotion_purchase_assistant';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->boolean('refunded')->nullable()->default(false);
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
