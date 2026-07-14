<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesStripeTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'prices_stripe';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->integer ('course_id')->unsigned ()->nullable();
            $table->string ('product_id_stripe',191)->nullable();
            $table->string ('prices_id_stripe',191)->nullable();
            $table->string ('interval_recurring',191)->nullable();
            $table->string ('stripe_description',191)->nullable();
            $table->tinyInteger ('is_active')->nullable ()->default (0);
            $table->dateTime('active_at')->nullable()->default(now()->addMonths (2));
            $table->dateTime('start_at')->nullable()->default(now()->addMonths (2));
            $table->dateTime('end_at')->nullable()->default(now()->addYear());
            $table->decimal ('price_subscription',10,2)->nullable ();
            $table->integer ('model_type')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::dropIfExists($this->tableName);
    }
}
