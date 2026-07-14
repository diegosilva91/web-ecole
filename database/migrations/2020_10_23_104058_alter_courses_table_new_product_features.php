<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTableNewProductFeatures extends Migration
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
        //
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->text('will_learn')->after('objectives')->nullable()->default(null);
            $table->text('short_intro')->after('intro')->nullable()->default(null);
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
        if (Schema::hasColumn($this->tableName, 'will_learn')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['will_learn','short_intro']);
            });
        }
    }
}
