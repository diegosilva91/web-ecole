<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixConditionsDeleteBetweenEntities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('promotion_purchase_assistant', function (Blueprint $table) {
                $table->dropForeign('promotion_purchase_assistant_promotion_purchase_id_foreign');
                $table->foreign('promotion_purchase_id', 'promotion_purchase_assistant_promotion_purchase_id_foreign')
                    ->references('id')->on('promotion_purchase')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->dropForeign('promotion_purchase_payment_promotion_purchase_id_foreign');
                $table->foreign('promotion_purchase_id', 'promotion_purchase_payment_promotion_purchase_id_foreign')
                    ->references('id')->on('promotion_purchase')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }

        if (Schema::hasColumn('courses', 'is_soon')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn(['is_soon']);
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
