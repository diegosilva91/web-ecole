<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTeachersAddFiscalData extends Migration
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
            $table->string ( 'business_name', 155 )->after ( 'slug' )->nullable ()->default ( null );
            $table->string ( 'nif_cif', 155 )->after ( 'business_name' )->nullable ()->default ( null );
            $table->string ( 'iban', 155 )->after ( 'nif_cif' )->nullable ()->default ( null );
            $table->string ( 'address', 155 )->after ( 'iban' )->nullable ()->default ( null );
            $table->string ( 'postal_code',155)->after ( 'address' )->nullable ()->default ( null );
            $table->string ( 'location', 155 )->after ( 'postal_code' )->nullable ()->default ( null );
            $table->string ( 'province', 155 )->after ( 'location' )->nullable ()->default ( null );
            $table->string ( 'country', 155 )->after ( 'province' )->nullable ()->default ( null );
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
        if (Schema::hasColumn($this->tableName, 'business_name')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('business_name');
            });
        }
        if (Schema::hasColumn($this->tableName, 'nif_cif')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('nif_cif');
            });
        }
        if (Schema::hasColumn($this->tableName, 'iban')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('iban');
            });
        }
        if (Schema::hasColumn($this->tableName, 'address')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }
        if (Schema::hasColumn($this->tableName, 'postal_code')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('postal_code');
            });
        }
        if (Schema::hasColumn($this->tableName, 'location')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('location');
            });
        }
        if (Schema::hasColumn($this->tableName, 'province')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('province');
            });
        }
        if (Schema::hasColumn($this->tableName, 'country')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn('country');
            });
        }
    }
}
