<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'courses';

    /**
     * Run the migrations.
     * @table courses
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('teacher_id')->nullable()->default(null);
            $table->integer('courses_category_id')->nullable()->default(null);
            $table->tinyInteger('is_featured')->nullable()->default(null);
            $table->tinyInteger('is_soon')->nullable()->default(null);
            $table->tinyInteger('is_verified')->nullable()->default(null);
            $table->tinyInteger('is_visible')->nullable()->default(null);
            $table->string('cover_image', 155)->nullable()->default(null);
            $table->string('cover_video', 155)->nullable()->default(null);
            $table->string('title', 155)->nullable()->default(null);
            $table->string('slug', 155)->nullable()->default(null);
            $table->string('intro')->nullable()->default(null);
            $table->string('duration', 55)->nullable()->default(null);
            $table->string('session', 55)->nullable()->default(null);
            $table->string('sessionTime', 55)->nullable()->default(null);
            $table->string('level', 55)->nullable()->default(null);
            $table->string('languages', 55)->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->text('objectives')->nullable()->default(null);
            $table->text('requirements')->nullable()->default(null);
            $table->string('price_total', 55)->nullable()->default(null);
            $table->string('price_per_class', 55)->nullable()->default(null);
            $table->integer('student_ages_max')->nullable()->default(null);
            $table->integer('student_ages_min')->nullable()->default(null);
            $table->integer('students_min')->nullable()->default(null);
            $table->integer('students_max')->nullable()->default(null);
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
