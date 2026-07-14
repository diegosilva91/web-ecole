<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionPurchaseAddStripeEvent extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'promotion_purchase';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::table ( $this->tableName, function ( Blueprint $table ) {
            $table->engine = 'InnoDB';
            $table->string ( 'stripe_payment_intent_token', 191 )->after ( 'stripe_charge_token' )->nullable ();
            $table->string ( 'stripe_event', 191 )->after ( 'stripe_payment_intent_token' )->nullable ();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        //
    }
}
