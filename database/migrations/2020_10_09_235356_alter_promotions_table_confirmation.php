<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionsTableConfirmation extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'promotions';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->boolean('confirmation_send')->after('is_blocked')->nullable()->default(0);
            $table->boolean('is_confirmed')->after('confirmation_send')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'confirmation_send')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['confirmation_send', 'is_confirmed']);
            });
        }
    }
}
