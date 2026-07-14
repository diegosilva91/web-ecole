<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewAgeInLeadUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_user', function (Blueprint $table) {
            $table->string('age_kids', 100)->nullable()->default(null)->after('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('lead_user', 'age_kids')) {
            Schema::table('lead_user', function (Blueprint $table) {
                $table->dropColumn(['age_kids']);
            });
        }
    }
}
