<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangesProfileTeacherDecember2021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable()->default(null)->after('is_verified');
            $table->string('cv', 155)->nullable()->default(null)->after('cv_rrss_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('teachers', 'verified_at')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn(['verified_at','cv']);
            });
        }
    }
}
