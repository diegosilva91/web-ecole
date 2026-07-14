<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionsAddDaily extends Migration
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
        Schema::table($this->tableName, function ($table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->text('daily')
                    ->after('end_at');
            } else {
                $table->text('daily')->default('["1"]')
                    ->after('end_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'daily')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['daily']);
            });
        };
    }
}
