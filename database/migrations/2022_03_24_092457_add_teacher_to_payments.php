<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherToPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_purchase_payment', function (Blueprint $table) {
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix().'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('teacher_id')->unsigned()->nullable()->default(null)->after('period_end');
            } else {
                $table->integer('teacher_id')->unsigned()->nullable()->default(null)->after('period_end');
            }
            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('promotion_purchase_payment', 'teacher_id')) {
            Schema::table('promotion_purchase_payment', function (Blueprint $table) {
                $table->dropColumn(['teacher_id']);
            });
        }
    }
}
