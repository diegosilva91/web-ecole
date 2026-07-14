<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddFieldsProfile extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function ($table) {
            $table->engine = 'InnoDB';
            $table->string ( 'birth', 155 )->after ( 'avatar' )->nullable ()->default ( null );
            $table->tinyInteger('notification_promotions')->after ( 'provider_id' )->nullable()->default(1);
            $table->tinyInteger('notification_news_courses')->after ( 'notification_promotions' )->nullable()->default(1);
            $table->tinyInteger('notification_resume_purchase')->after ( 'notification_news_courses' )->nullable()->default(1);
            $table->tinyInteger('notification_link_course')->after ( 'notification_resume_purchase' )->nullable()->default(1);
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
        if (Schema::hasColumn($this->tableName, 'birth')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('birth');
            });
        }
        if (Schema::hasColumn($this->tableName, 'notification_promotions')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('notification_promotions');
            });
        }
        if (Schema::hasColumn($this->tableName, 'notification_news_courses')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('notification_news_courses');
            });
        }
        if (Schema::hasColumn($this->tableName, 'notification_resume_purchase')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('notification_resume_purchase');
            });
        }
    }
}
