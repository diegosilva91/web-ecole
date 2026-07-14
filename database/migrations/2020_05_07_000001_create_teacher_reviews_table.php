<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherReviewsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'teacher_reviews';

    /**
     * Run the migrations.
     * @table teachers_reviews
     *
     * @return void
     */
    public function up()
    
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('teacher_id')->nullable()->default(null);
            $table->smallInteger('value')->nullable()->default(null);
            $table->string('content')->nullable()->default(null);
            $table->string('user', 155)->nullable()->default(null);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
