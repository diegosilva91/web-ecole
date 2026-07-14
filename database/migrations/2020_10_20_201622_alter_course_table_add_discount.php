<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCourseTableAddDiscount extends Migration
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
            $table->decimal('discount', 10,2)->after('price_per_class')->nullable()->default(20.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'discount')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['discount']);
            });
        }
    }
}
