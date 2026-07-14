<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationsTwoAfterCreate extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'courses';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::disableForeignKeyConstraints();
        Schema::table($this->tableName,function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('courses_teacher_id_foreign');
            }
            $table->dropColumn('teacher_id');
            $table->bigInteger('user_id')->unsigned()->after('id')->nullable()->default(null);
            $table->foreign('user_id', 'courses_user_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('course_id')->unsigned()->change();
            $table->foreign('course_id', 'promotions_course_id_foreign')
                ->references('id')->on('courses')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('promotion_purchase', function (Blueprint $table) {
            $table->integer('promotion_id')->unsigned()->change();
            $table->foreign('promotion_id', 'promotion_purchase_promotion_id_foreign')
                ->references('id')->on('promotions')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('promotion_purchase_assistant', function (Blueprint $table) {
            $table->integer('promotion_purchase_id')->unsigned()->change();
            $table->foreign('promotion_purchase_id', 'promotion_purchase_assistant_promotion_purchase_id_foreign')
                ->references('id')->on('promotion_purchase')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
