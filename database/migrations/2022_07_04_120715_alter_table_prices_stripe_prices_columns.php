<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePricesStripePricesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('prices_stripe', 'prices_id_stripe')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->string('prices_id_stripe_basic', 191)->after('prices_id_stripe')->nullable();
                $table->string('prices_id_stripe_lifecooler', 191)->after('prices_id_stripe_basic')->nullable();
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
        if (Schema::hasColumn('prices_stripe', 'prices_id_stripe_basic')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['prices_id_stripe_basic']);
            });
        }
        if (Schema::hasColumn('prices_stripe', 'prices_id_stripe_lifecooler')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['prices_id_stripe_lifecooler']);
            });
        }
    }
}
