<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddSocialIdColumn extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function ($table) {
            $table->string('provider')->after('status')->nullable();
            $table->string('provider_id')->after('provider')->nullable();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'provider_id') && Schema::hasColumn($this->tableName, 'provider')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['provider_id','provider']);
            });
        };
    }
}
