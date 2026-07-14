<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRecommendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_recommenders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('token_typeform', 155)->nullable()->default(null);
            $table->uuid('u_key');
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix().'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('user_id')->unsigned()->nullable ()->default (null)->index();
            } else {
                $table->integer('user_id')->unsigned()->nullable ()->default (null)->index();
            }
            $table->foreign('user_id')->references('id')->on('users');
            if (DB::getDriverName() !== 'sqlite') {
                $table->text ( 'recommender_type' )->nullable ();
            }else{
                $table->text ( 'recommender_type' )->default('[]');
            }

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
        Schema::dropIfExists('course_recommenders');
    }
}
