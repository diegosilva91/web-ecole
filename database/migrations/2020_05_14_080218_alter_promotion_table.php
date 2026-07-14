<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionTable extends Migration
{
    public $tableName="promotions";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (Schema::hasColumn('promotions', 'start_at')){
            Schema::table($this->tableName,function (Blueprint $table) {            
                $table->dateTime('start_at', 0)->nullable()->change();
            });
        }
        if (Schema::hasColumn('promotions', 'end_at')){
            Schema::table($this->tableName,function (Blueprint $table) {            
                $table->dateTime('end_at', 0)->nullable()->change();
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
