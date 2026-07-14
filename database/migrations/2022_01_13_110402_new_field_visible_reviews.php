<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFieldVisibleReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_reviews', function (Blueprint $table) {
            $table->tinyInteger('is_visible')->default(1)->after('opinion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('course_reviews', 'is_visible')) {
            Schema::table('course_reviews', function (Blueprint $table) {
                $table->dropColumn(['is_visible']);
            });
        }
    }
}
