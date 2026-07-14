<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionPurchaseTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'promotion_purchase';

    /**
     * Run the migrations.
     * @table promotion_purchase
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('promotion_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->string('stripe_customer_token')->nullable()->default(null);
            $table->string('stripe_charge_token')->nullable()->default(null);
            $table->decimal('total_price', 10, 2)->nullable()->default(null);
            $table->string('currency', 15)->nullable()->default(null);
            $table->string('payment_type', 55)->nullable()->default(null);
            $table->string('payment_status', 55)->nullable()->default(null);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
