<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCustomersAddFieldsUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('customers', 'alternative_email')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('provider')->after('alternative_email')->nullable();
                $table->string('provider_id')->after('provider')->nullable();
                $table->tinyInteger('notification_promotions')->after('provider_id')->nullable()->default(1);
                $table->string('stripe_id')->after('notification_promotions')->default(null)->nullable()->index()->unique();
                $table->string('paypal_payer_id')->after('stripe_id')->default(null)->nullable()->index()->unique();
            });
        }
        Schema::disableForeignKeyConstraints();

        if (Schema::hasColumn('customers', 'sender_id')) {
            Schema::table('customers', function (Blueprint $table) {
                if (DB::getDriverName() !== 'sqlite') {
                    $table->dropForeign(['sender_id']);
                }
                $table->dropColumn(['sender_id']);
            });
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('customers', 'provider')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn(['provider']);
            });
        }
        if (Schema::hasColumn('customers', 'provider_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn(['provider_id']);
            });
        }
        if (Schema::hasColumn('customers', 'notification_promotions')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn(['notification_promotions']);
            });
        }
        if (Schema::hasColumn('customers', 'stripe_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn(['stripe_id']);
            });
        }
        if (Schema::hasColumn('customers', 'paypal_payer_id')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->dropColumn(['paypal_payer_id']);
            });
        }
    }
}
