<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionPurchaseAssistant extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'promotion_purchase_assistant';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            //$table->integer('user_assistant_id')->unsigned()->index()->after('promotion_purchase_id');
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix().'user_assistant', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('user_assistant_id')->nullable()->unsigned()->index();
            } else {
                $table->integer('user_assistant_id')->nullable()->unsigned()->index();
            }
            $table->foreign('user_assistant_id')->references('id')->on('user_assistant')->onDelete('cascade');
            if (DB::getDriverName() !== 'sqlite') {
                $table->string('name')->after('promotion_purchase_id');
                $table->string('age')->after('name');
            } else {
                $table->string('name')->nullable()->after('promotion_purchase_id');
                $table->string('age')->nullable()->after('name');
            }
        //
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
