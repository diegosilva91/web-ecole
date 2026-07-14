<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanUnusedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'api_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['api_token','card_brand','card_last_four','trial_ends_at']);
            });
        }

        if (Schema::hasColumn('courses', 'short_intro')) {
            Schema::table('courses', function (Blueprint $table) {
                $table->dropColumn(['short_intro']);
            });
        }

        if (Schema::hasColumn('course_skills', 'created_at')) {
            Schema::table('course_skills', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at']);
            });
        }

        if (Schema::hasColumn('course_requirements', 'created_at')) {
            Schema::table('course_requirements', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at']);
            });
        }

        if (Schema::hasColumn('course_users', 'created_at')) {
            Schema::table('course_users', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at']);
            });
        }

        if (Schema::hasColumn('favourites_courses', 'created_at')) {
            Schema::table('favourites_courses', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at']);
            });
        }

        if (Schema::hasColumn('requirements', 'created_at')) {
            Schema::table('requirements', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at']);
            });
        }

        if (Schema::hasColumn('skills', 'created_at')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at']);
            });
        }

        if (Schema::hasColumn('course_categories', 'created_at')) {
            Schema::table('course_categories', function (Blueprint $table) {
                $table->dropColumn(['created_at','updated_at','caption','priority']);
            });
        }
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
