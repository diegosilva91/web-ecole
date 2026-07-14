<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandPageCoursesTable extends Migration
{
        /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'land_pages_courses';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            //$table->increments('id');
            $table->integer('land_page_id')->unsigned()->index();//it's not necessary
            $table->integer('course_id')->unsigned()->index();
            $table->foreign('land_page_id')->references('id')->on('land_pages')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            //$table->primary(['land_pages_id', 'course_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('land_page_courses');
    }
}
