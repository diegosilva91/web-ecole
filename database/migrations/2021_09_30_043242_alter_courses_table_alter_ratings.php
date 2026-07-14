<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCoursesTableAlterRatings extends Migration
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
            if (Schema::hasColumn($this->tableName, 'puntuation')) {
                $table->dropColumn('puntuation');
            }
            if (Schema::hasColumn($this->tableName, 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn($this->tableName, 'comunication')) {
                $table->dropColumn('comunication');
            }
            if (Schema::hasColumn($this->tableName, 'flexibility')) {
                $table->dropColumn('flexibility');
            }
            if ( DB::getDriverName () !== 'sqlite' ) {
                $table->renameColumn('valorations', 'total_reviews');
                $table->renameColumn('general_valoration', 'avg_reviews');
            }else{
                $table->decimal('total_reviews',10)->after('meta_description')->default(0);
                $table->decimal('avg_reviews',10)->after('total_reviews')->default(0);
                if (Schema::hasColumn($this->tableName, 'valorations') && Schema::hasColumn($this->tableName, 'general_valoration')) {
                    $table->dropColumn([ 'valorations', 'general_valoration' ]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            if (Schema::hasColumn($this->tableName, 'total_reviews')) {
                $table->renameColumn('total_reviews','valorations');
            }
            if (Schema::hasColumn($this->tableName, 'avg_reviews')) {
                $table->renameColumn('avg_reviews', 'general_valoration');
            }
        });
    }
}
