<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewFieldTagsToLeadUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_user', function (Blueprint $table) {
            $table->text('tags')->after('interest')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('lead_user', 'tags')) {
            Schema::table('lead_user', function (Blueprint $table) {
                $table->dropColumn(['tags']);
            });
        }
    }
}
