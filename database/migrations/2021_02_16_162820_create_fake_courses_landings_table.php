<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFakeCoursesLandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fake_courses_landings', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->nullable()->default(null);
            $table->string('category_id')->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->string('cover_image')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fake_courses_landings');
    }
}
