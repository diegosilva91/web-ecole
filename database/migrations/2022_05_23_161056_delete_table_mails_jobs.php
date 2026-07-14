<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTableMailsJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mails_jobs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('mails_jobs', function (Blueprint $table) {
            $table->id();
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix() . 'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('user_id')->unsigned()->index();
            } else {
                $table->integer('user_id')->unsigned()->index();
            }
            $table->integer('stage')->nullable()->default(0);
            $table->string('status', 191)->nullable()->default('pending');
            $table->string('process', 191)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
}
