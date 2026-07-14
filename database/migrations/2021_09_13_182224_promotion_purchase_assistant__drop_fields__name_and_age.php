<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PromotionPurchaseAssistantDropFieldsNameAndAge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_purchase_assistant', function (Blueprint $table) {
            if (Schema::hasColumn('promotion_purchase_assistant', 'name')) {
                $table->dropColumn([ 'name' ]);
            }
        });
        Schema::table('promotion_purchase_assistant', function (Blueprint $table) {
            if (Schema::hasColumn('promotion_purchase_assistant', 'age')) {
                $table->dropColumn([ 'age' ]);
            }
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
