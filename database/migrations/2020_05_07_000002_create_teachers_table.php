<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'teachers';

    /**
     * Run the migrations.
     * @table teachers
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(null);
            $table->string('phone', 155)->nullable()->default(null);
            $table->string('cover_image', 155)->nullable()->default(null);
            $table->string('bio')->nullable()->default(null);
            $table->string('title', 155)->nullable()->default(null);
            $table->string('slug', 155)->nullable()->default(null);
            $table->smallInteger('total_reviews')->nullable()->default(null);
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
