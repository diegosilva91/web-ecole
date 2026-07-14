<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTeachersAddTypeformsFields extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'teachers';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->tableName, function ($table) {
            $table->engine = 'InnoDB';
            $table->string('token_typeform', 155)->after('user_id')->nullable()->default(null);
            $table->tinyInteger('have_experience')->after('slug')->nullable()->defalt(0);
            if(DB::getDriverName()!=='sqlite') {
                $table->text ( 'experience_description' )->after ( 'have_experience' )->nullable ()->default ( null );
                $table->text ( 'categories_preferences' )->after ( 'experience_description' )->nullable ()->default ( null );

            }else{
                $table->text ( 'experience_description' )->after ( 'have_experience' )->default ( '');
                $table->text ( 'categories_preferences' )->after ( 'experience_description' )->default ( '["1"]' );

            }
            $table->string('cv_rrss_url', 155)->after('categories_preferences')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->tableName, 'token_typeform')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['token_typeform']);
            });
        }
        if (Schema::hasColumn($this->tableName, 'have_experience')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['have_experience']);
            });
        }
        if (Schema::hasColumn($this->tableName, 'experience_description')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['experience_description']);
            });
        }
        if (Schema::hasColumn($this->tableName, 'categories_preferences')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['categories_preferences']);
            });
        }
        if (Schema::hasColumn($this->tableName, 'cv_rrss_url')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['cv_rrss_url']);
            });
        }
    }

}
