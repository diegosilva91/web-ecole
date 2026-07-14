<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCouponsTableAddTraceability extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'coupons';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix().'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('owner_id')->after('is_active')->unsigned()->index()->nullable();
            } else {
                $table->integer('owner_id')->after('is_active')->unsigned()->index()->nullable();
            }
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('expire_at')->after('owner_id')->nullable()->default(now());
            $table->integer('counter')->after('expire_at')->nullable()->default(0);
            $table->integer('limit')->after('counter')->nullable()->default(1);
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
        if (Schema::hasColumn($this->tableName, 'owner_id')) {
            Schema::table($this->tableName, function (Blueprint $table) {
                $table->dropColumn(['limit','expire_at','counter']);
                if (DB::getDriverName() !== 'sqlite') { //
                    $table->dropForeign(['owner_id']);
                }
                $table->dropColumn(['owner_id']);
            });
        }
    }
}
