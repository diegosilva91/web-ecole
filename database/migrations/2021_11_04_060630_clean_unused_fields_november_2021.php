<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CleanUnusedFieldsNovember2021 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('courses', 'availability_days_hours')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn(['availability_days_hours', 'is_verified', 'price_per_class', 'first_class_free', 'languages']);

                if (DB::getDriverName() !== 'sqlite') {
                    $table->smallInteger('total_reviews')->default(0)->change();
                    $table->decimal('avg_reviews', 10)->default(0)->change();
                } else {
                    $table->string('total_reviews', 10)->default(NULL)->change();
                    $table->string('avg_reviews', 10)->default(NULL)->change();
                }
            });
        }

        if (Schema::hasColumn('promotion_purchase', 'promotion_is_modifiable')) {
            Schema::table('promotion_purchase', function (Blueprint $table) {
                $table->dropColumn(['promotion_is_modifiable']);
            });
        }

        if (Schema::hasColumn('promotion_purchase_assistant', 'refunded')) {
            Schema::table('promotion_purchase_assistant', function (Blueprint $table) {
                $table->dropColumn(['refunded']);
            });
        }

        if (Schema::hasColumn('promotions', 'title')) {
            Schema::table('promotions', function (Blueprint $table) {
                $table->dropColumn(['title', 'is_cancelled', 'is_blocked', 'confirmation_send', 'is_confirmed']);
            });
        }

        if (Schema::hasColumn('promotion_purchase', 'stripe_event')) {
            Schema::table('promotion_purchase', function (Blueprint $table) {
                $table->dropColumn(['stripe_event','payment_type']);
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
        Schema::table('courses', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->text('availability_days_hours')->after('daily')->nullable();
            } else {
                $table->text('availability_days_hours')->default('[["0":"0"]]')->after('daily');
            }
            $table->tinyInteger('is_verified')->after('token_typeform')->nullable()->default(0);
            $table->string('price_per_class', 55)->nullable()->default(null);
            $table->tinyInteger('first_class_free')->after('price_per_class')->nullable()->default(0);
            $table->string('languages', 55)->nullable()->default(null);
        });

        Schema::table('promotion_purchase', function (Blueprint $table) {
            $table->boolean('promotion_is_modifiable')->after('payment_status_error')->nullable()->default(1);
        });

        Schema::table('promotion_purchase_assistant', function (Blueprint $table) {
            $table->boolean('refunded')->nullable()->default(false);
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->string('title')->nullable()->default(null);
            $table->boolean('confirmation_send')->after('is_blocked')->nullable()->default(0);
            $table->boolean('is_confirmed')->after('confirmation_send')->nullable()->default(1);
            $table->boolean('is_blocked')->nullable()->after('is_cancelled');
            $table->tinyInteger('is_cancelled')->nullable()->default(null);
        });

        Schema::table('promotion_purchase', function (Blueprint $table) {
            $table->string('stripe_event', 191)->after('stripe_payment_intent_token')->nullable();
        });
    }
}
