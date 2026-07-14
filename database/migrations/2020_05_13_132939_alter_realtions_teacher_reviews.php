<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRealtionsTeacherReviews extends Migration
{
    public $tableName = 'teacher_reviews';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table($this->tableName,function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
            $table->dropForeign('teacher_reviews_teacher_id_foreign');
            }
            $table->dropColumn('teacher_id');
            $table->bigInteger('user_id')->unsigned()->after('id')->nullable()->default(null);
            $table->foreign('user_id', 'teacher_reviews_user_id_foreign')
                ->references('id')->on('users')
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
