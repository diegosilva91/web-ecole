<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReasonLostLead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_opportunity', function (Blueprint $table) {
            $table->tinyInteger('lost_reason')->nullable()->default(null)->after('origin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('lead_opportunity', 'reason_lost')) {
            Schema::table('lead_opportunity', function (Blueprint $table) {
                $table->dropColumn(['lost_reason']);
            });
        }
    }
}
