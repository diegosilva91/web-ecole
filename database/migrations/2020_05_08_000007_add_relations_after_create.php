<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationsAfterCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() !== 'sqlite') { //

        }
        Schema::table('teachers', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id', 'teacher_user_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('teacher_reviews', function (Blueprint $table) {
            $table->integer('teacher_id')->unsigned()->change();
            $table->foreign('teacher_id', 'teacher_reviews_teacher_id_foreign')
                ->references('id')->on('teachers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('teacher_id')->unsigned()->change();
            $table->foreign('teacher_id', 'courses_teacher_id_foreign')
                ->references('id')->on('teachers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('courses_category_id')->unsigned()->change();
            $table->foreign('courses_category_id','courses_category_id_foreign')
                ->references('id')->on('course_categories')
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
        if (DB::getDriverName() !== 'sqlite') { //
            //
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropForeign(['teacher_user_id_foreign']);
            });
            Schema::table('teachers_reviews', function (Blueprint $table) {
                $table->dropForeign(['teacher_reviews_teacher_id_foreign']);
            });
            Schema::table('courses', function (Blueprint $table) {
                $table->dropForeign(['courses_teacher_id_foreign']);
            });
        }
    }
}
