<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('provider');
            $table->integer('status');
            $table->string('payment_event_id',191)->nullable();
            $table->integer ( 'promotion_purchase_id')->unsigned ()->index ()->nullable();
            $table->string('event_type',191)->nullable();
            $table->text('payload')->nullable();
            $table->timestamps();

            $table->foreign ( 'promotion_purchase_id' )->references ( 'id' )->on ( 'promotion_purchase' )->onDelete ( 'cascade' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments_events');
    }
}
