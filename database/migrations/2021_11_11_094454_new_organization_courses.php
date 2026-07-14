<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewOrganizationCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger('type_course')->after('id')->default(0);
            $table->tinyInteger('subtype_course')->after('type_course')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('courses', 'type_course')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn(['type_course', 'subtype_course']);
            });
        }
    }
}
