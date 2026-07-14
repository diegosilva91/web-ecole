<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserAssistantsTableAddEmailField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_assistant', function (Blueprint $table) {
            $table->string('email')->after('age')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_assistant', 'email')) {
            Schema::table('user_assistant', function (Blueprint $table) {
                $table->dropColumn(['email']);
            });
        }
    }
}
