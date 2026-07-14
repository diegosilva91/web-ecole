<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommentsCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('owner_id')->unsigned()->nullable();

            $table->text('info');
            $table->integer('type');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });


        Schema::table('customer_comment', function (Blueprint $table) {
            $table->foreign('user_id', 'customer_comment_user_id_foreign')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('owner_id', 'customer_comment_owner_id_foreign')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_comment');
    }
}
