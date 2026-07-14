<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingQuestionnaire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('landing_questionnaire', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('subject', 255);
            $table->text('body');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedInteger('landing_questionnaire_id')->after('avg_reviews')->nullable();
            $table->foreign('landing_questionnaire_id', 'landing_questionnaire_course_id_foreign')->references('id')->on('landing_questionnaire')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_questionnaire');
        if (Schema::hasColumn('courses', 'email')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropForeign('landing_questionnaire_id');
                $table->dropColumn(['landing_questionnaire_id']);
            });
        }
    }
}

