<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesAddSubcategories extends Migration
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
        Schema::table($this->tableName, function ($table) {
            $table->engine = 'InnoDB';
            $table->string ( 'sub_categories', 155 )->after ( 'courses_category_id' )->nullable ()->default ( null );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'sub_categories')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('sub_categories');
            });
        }
    }
}
