<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogbook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbook', function (Blueprint $table) {
            $table->id();

            $table->string('action', 60);
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix().'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('user_id')->unsigned()->nullable()->default(null)->index();
            } else {
                $table->integer('user_id')->unsigned()->nullable()->default(null)->index();
            }
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('object_type', 60)->nullable()->default(null);
            $table->integer('object_id')->nullable()->default(null);
            $table->timestamp('occurred_on');
            $table->text('metadata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logbook');
    }
}
