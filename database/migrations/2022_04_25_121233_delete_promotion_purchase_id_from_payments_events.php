<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeletePromotionPurchaseIdFromPaymentsEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('payments_events', 'promotion_purchase_id')) {
            Schema::table('payments_events', function (Blueprint $table) {
                if (DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign(['promotion_purchase_id']);
                }
                $table->dropColumn(['promotion_purchase_id']);
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
        if (!Schema::hasColumn('payments_events', 'promotion_purchase_id')) {
            Schema::table('payments_events', function (Blueprint $table) {
                $table->integer('promotion_purchase_id')->after('id')->unsigned()->index()->nullable();
                $table->foreign('promotion_purchase_id')->references('id')->on('promotion_purchase')->onDelete('cascade');
            });
        }
    }
}
