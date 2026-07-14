<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanTablePricesStripe extends Migration
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
                $table->renameColumn('prices_id_stripe', 'prices_id_stripe_old');
            });
        }
        if (Schema::hasColumn('prices_stripe', 'interval_recurring')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['interval_recurring']);
            });
        }
        if (Schema::hasColumn('prices_stripe', 'active_at')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['active_at']);
            });
        }
        if (Schema::hasColumn('prices_stripe', 'start_at')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['start_at']);
            });
        }
        if (Schema::hasColumn('prices_stripe', 'end_at')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['end_at']);
            });
        }
        if (Schema::hasColumn('prices_stripe', 'stripe_description')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dropColumn(['stripe_description']);
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
        if (!Schema::hasColumn('prices_stripe', 'prices_id_stripe_old')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->renameColumn('prices_id_stripe_old', 'prices_id_stripe');
            });
        }
        if (!Schema::hasColumn('prices_stripe', 'interval_recurring')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->string('interval_recurring', 191)->nullable();
            });
        }
        if (!Schema::hasColumn('prices_stripe', 'is_active')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->tinyInteger('is_active')->nullable()->default(0);
            });
        }
        if (!Schema::hasColumn('prices_stripe', 'active_at')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dateTime('active_at')->nullable()->default(now()->addMonths(2));
            });
        }
        if (!Schema::hasColumn('prices_stripe', 'start_at')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dateTime('start_at')->nullable()->default(now()->addMonths(2));
            });
        }
        if (!Schema::hasColumn('prices_stripe', 'end_at')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->dateTime('end_at')->nullable()->default(now()->addYear());
            });
        }
        if (!Schema::hasColumn('prices_stripe', 'stripe_description')) {
            Schema::table('prices_stripe', function (Blueprint $table) {
                $table->string('stripe_description', 191)->nullable();
            });
        }
    }
}
