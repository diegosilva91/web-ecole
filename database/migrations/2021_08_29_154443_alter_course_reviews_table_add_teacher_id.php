<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCourseReviewsTableAddTeacherId extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public string $tableName = 'course_reviews';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//
        Schema::table ( $this->tableName, function ( Blueprint $table ) {

            $type = DB::connection ()->getDoctrineColumn ( DB::getTablePrefix () . 'users', 'id' )->getType ()->getName ();
            if ( $type == 'bigint' ) {
                $table->bigInteger ( 'teacher_id' )->after ( 'user_id' )->unsigned ()->index ()->nullable();
            }
            else {
                $table->integer ( 'teacher_id' )->after ( 'user_id' )->unsigned ()->index ()->nullable();
            }
            $table->foreign ( 'teacher_id' )->references ( 'id' )->on ( 'users' )->onDelete ( 'cascade' );
            if ( DB::getDriverName () !== 'sqlite' ) {
                $table->text ( 'opinion' )->change ();
            }
            else {
                $table->text ( 'opinion' )->change ();
            }
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ( DB::getDriverName () !== 'sqlite' ) { //
            Schema::table ( $this->tableName, function ( Blueprint $table ) {
                $table->dropForeign ( [ 'teacher_id' ] );
            } );
        }
        if ( Schema::hasColumn ( $this->tableName, 'opinions' ) ) {
            Schema::table ( $this->tableName, function ( Blueprint $table ) {
                $table->string ( 'opinion' )->change ();
            } );
        }
        if ( Schema::hasColumn ( $this->tableName, 'teacher_id' ) ) {
            Schema::table ( $this->tableName, function ( Blueprint $table ) {
                $table->dropColumn ( 'teacher_id' );
            } );
        }


    }
}
