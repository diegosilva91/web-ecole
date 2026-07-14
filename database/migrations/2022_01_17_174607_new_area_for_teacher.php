<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewAreaForTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->bigInteger('course_area_id')->unsigned()->nullable()->default(null)->after('slug');
            $table->foreign('course_area_id','course_area_teachers_foreign')
                ->references('id')->on('course_area')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('teachers', 'course_area_id')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn(['course_area_id']);
            });
        }
    }
}
