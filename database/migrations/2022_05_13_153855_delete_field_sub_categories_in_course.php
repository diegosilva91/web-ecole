<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteFieldSubCategoriesInCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('courses', 'sub_categories')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn(['sub_categories']);
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
        Schema::table('courses', function ($table) {
            $table->engine = 'InnoDB';
            $table->string ( 'sub_categories', 155 )->after ( 'courses_category_id' )->nullable ()->default ( null );
        });
    }
}
