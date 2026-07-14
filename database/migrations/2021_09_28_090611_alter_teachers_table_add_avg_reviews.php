<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTeachersTableAddAvgReviews extends Migration
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
            $table->decimal('avg_reviews',10)->after('total_reviews')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'avg_reviews')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('avg_reviews');

            });
        }
    }
}
