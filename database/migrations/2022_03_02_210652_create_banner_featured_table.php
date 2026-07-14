<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerFeaturedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_featured', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->integer('category_id');
            $table->string('image', 255);
            $table->string('label_color', 7)->nullable();
            $table->string('label_text', 30)->nullable();
            $table->string('url', 255);
            $table->integer('order_banner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_featured');
    }
}
