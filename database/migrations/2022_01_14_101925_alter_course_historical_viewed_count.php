<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCourseHistoricalViewedCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_historical_viewed', function (Blueprint $table) {
            $table->integer('counter')->nullable()->default(0)->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('courses_historical_viewed', 'counter')) {
            Schema::table('courses_historical_viewed', function (Blueprint $table) {
                $table->dropColumn(['counter']);
            });
        }
    }
}
