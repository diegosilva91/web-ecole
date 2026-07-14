<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePromotionPurchaseAddPackData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('promotion_purchase', 'type_payment')) {
            Schema::table('promotion_purchase', function (Blueprint $table) {
                $table->integer('type_pack')->after('type_payment')->nullable();
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
        if (Schema::hasColumn('promotion_purchase', 'type_pack')) {
            Schema::table('promotion_purchase', function (Blueprint $table) {
                $table->dropColumn(['type_pack']);
            });
        }
    }
}
