<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseCategories extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'course_categories';

    /**
     * Run the migrations.
     * @table promotion_purchase
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title',155)->nullable()->default(null);
            $table->string('caption',155)->nullable()->default(null);
            $table->string('slug',155)->nullable()->default(null);
            $table->integer('priority')->nullable()->default(null);
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
