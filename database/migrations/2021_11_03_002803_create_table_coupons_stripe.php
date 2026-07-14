<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCouponsStripe extends Migration
{
    private $tableName='coupons';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->integer('type_coupon')->after('id')->default(1);
            $table->text('metadata')->nullable();//relativa a otras plataformas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (Schema::hasColumns($this->tableName, [ 'type_coupon', 'metadata' ])) {
                $table->dropColumn([ 'type_coupon', 'metadata' ]);
            }
        });
    }
}
