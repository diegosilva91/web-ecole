<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseReviewsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'course_reviews';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix().'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('user_id')->unsigned()->index()->nullable();
            } else {
                $table->integer('user_id')->unsigned()->index()->nullable();
            }
            $table->integer('course_id')->unsigned()->index();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->decimal('rating1', 10, 2)->nullable()->default(null);
            $table->decimal('rating2', 10, 2)->nullable()->default(null);
            $table->decimal('rating3', 10, 2)->nullable()->default(null);
            $table->decimal('rating4', 10, 2)->nullable()->default(null);
            $table->string('opinion')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (DB::getDriverName() !== 'sqlite') { //
            Schema::table ( $this->tableName, function ( Blueprint $table ) {
                $table->dropForeign ( [ 'user_user_id_foreign' ] );
                $table->dropForeign ( [ 'course_course_id_foreign' ] );
            } );
        }
        Schema::dropIfExists($this->tableName);
    }
}
