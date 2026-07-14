<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTableAddSubscriptionsStripeItems extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'courses';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table($this->tableName, function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->string ('product_id_stripe')->after ( 'sub_categories' )->nullable ()->default (null)->index();
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
        Schema::table($this->tableName, function (Blueprint $table) {
            if (Schema::hasColumn($this->tableName, 'product_id_stripe')) {
                $table->dropColumn('product_id_stripe');
            }
        });
    }
}
