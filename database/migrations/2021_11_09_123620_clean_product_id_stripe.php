<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanProductIdStripe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('courses', 'product_id_stripe')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn(['product_id_stripe']);
            });
        }

        if (Schema::hasColumn('prices_stripe', 'product_id_stripe')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['product_id_stripe']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('product_id_stripe', 191)->nullable();
        });

        Schema::create('prices_stripe', function (Blueprint $table) {
            $table->string('product_id_stripe', 191)->nullable();
        });
    }
}
