<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTableAddSubscriptionsFields extends Migration
{
    private string $tableName = 'courses';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->string('total_level')->after('level')->nullable()->default(null);
            $table->string('content_detail')->after('cover_video')->nullable()->default(null);
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
        if ( Schema::hasColumn ( $this->tableName, 'total_level' ) ) {
            Schema::table ( $this->tableName, function ( Blueprint $table ) {
                $table->dropColumn('total_level');
            } );
        }
        if ( Schema::hasColumn ( $this->tableName, 'content_detail' ) ) {
            Schema::table ( $this->tableName, function ( Blueprint $table ) {
                $table->dropColumn('content_detail');
            } );
        }
    }
}
