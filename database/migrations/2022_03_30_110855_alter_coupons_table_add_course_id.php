<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCouponsTableAddCourseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('coupons', function (Blueprint $table) {
            $table->integer('course_id')->after('owner_id')->unsigned()->index()->nullable();
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('coupons', 'course_id')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('course_id');
//                if (DB::getDriverName() !== 'sqlite') {
//                    $table->dropForeign(['course_id']);
//                }
            });
        }
    }
}
