<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeadStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');

            $table->bigInteger('lead_opportunity_id')->unsigned()->nullable();

            $table->string('email', 120)->nullable();
            $table->string('phone', 80)->nullable();
            $table->string('name', 80);
            $table->dateTime('call_at')->nullable();
            $table->text('info')->nullable();
            $table->string('interest', 255)->nullable();
            $table->dateTime('last_activity')->useCurrent();

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::create('lead_opportunity', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('commercial_id')->unsigned()->nullable();

            $table->dateTime('received_at');
            $table->dateTime('closed_at')->nullable();
            $table->integer('status');
            $table->integer('origin');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::create('lead_comment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('owner_id')->unsigned()->nullable();

            $table->text('info');
            $table->integer('type');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });

        Schema::table('lead_user', function (Blueprint $table) {
            $table->foreign('lead_opportunity_id', 'lead_user_lead_opportunity_id_foreign')
                ->references('id')->on('lead_opportunity')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('lead_opportunity', function (Blueprint $table) {
            $table->foreign('user_id', 'lead_opportunity_user_id_foreign')
                ->references('id')->on('lead_user')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('commercial_id', 'lead_opportunity_commercial_id_foreign')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
        });

        Schema::table('lead_comment', function (Blueprint $table) {
            $table->foreign('user_id', 'lead_comment_user_id_foreign')
                ->references('id')->on('lead_user')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('owner_id', 'lead_comment_owner_id_foreign')
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
        Schema::dropIfExists('lead_user');
        Schema::dropIfExists('lead_comment');
        Schema::dropIfExists('lead_opportunity');
    }
}
