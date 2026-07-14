<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTeachersAddIsVerified extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'teachers';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->tableName, function ($table) {
            $table->engine = 'InnoDB';
            $table->tinyInteger('is_verified')->after ( 'token_typeform' )->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        if (Schema::hasColumn($this->tableName, 'is_verified')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('is_verified');
            });
        }
    }
}
