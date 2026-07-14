<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldCheckInPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('promotion_purchase', 'checked')) {
            Schema::table('promotion_purchase', function (Blueprint $table) {
                $table->dropColumn(['checked']);
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
        Schema::table('promotion_purchase', function (Blueprint $table) {
            $table->tinyInteger('checked')->nullable()->default(0);
        });
    }
}
