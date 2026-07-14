<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTeachersTableAddRatingsNames extends Migration
{
    private string $tableName = 'teachers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->decimal('rating1',10)->after('avg_reviews')->default(0);
            $table->decimal('rating2',10)->after('rating1')->default(0);
            $table->decimal('rating3',10)->after('rating2')->default(0);
            $table->decimal('rating4',10)->after('rating3')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'rating1')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('rating1');

            });
        }
        if (Schema::hasColumn($this->tableName, 'rating2')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('rating2');
            });
        }
        if (Schema::hasColumn($this->tableName, 'rating3')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('rating3');
            });
        }
        if (Schema::hasColumn($this->tableName, 'rating4')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('rating4');
            });
        }
    }
}
