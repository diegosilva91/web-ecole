<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTableAddFirstClassFreeColumn extends Migration
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
        //
        //
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyInteger ( 'first_class_free' )->after ( 'price_per_class' )->nullable ()->default ( 0 );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'first_class_free')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['first_class_free']);
            });
        }
    }
}
