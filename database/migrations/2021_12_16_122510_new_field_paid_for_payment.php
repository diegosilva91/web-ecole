<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFieldPaidForPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_purchase_payment', function (Blueprint $table) {
            $table->timestamp('paid_at')->nullable()->default(null)->after('payment_status_error');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('promotion_purchase_payment', 'paid_at')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->dropColumn(['paid_at']);
            });
        }
    }
}
