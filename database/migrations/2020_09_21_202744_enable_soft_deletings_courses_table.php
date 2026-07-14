<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnableSoftDeletingsCoursesTable extends Migration
{
    public $tableName="courses";
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->tableName,function (Blueprint $table) {
            $table->softDeletes();
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
        if (Schema::hasColumn('courses', 'delete_at')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
}
