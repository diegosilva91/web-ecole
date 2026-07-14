<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTableAddAvailabilityDaysHoursColumnJson extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'courses';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            if (DB::getDriverName() !== 'sqlite') {
                $table->text ( 'availability_days_hours' )->after ( 'daily' )->nullable ();
            }else{
                $table->text ( 'availability_days_hours' )->default('[["0":"0"]]')->after ( 'daily' );
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
        if (Schema::hasColumn($this->tableName, 'availability_days_hours')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['availability_days_hours']);
            });
        }
    }
}
