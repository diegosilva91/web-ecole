<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BetterOrganizationUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'notification_link_course')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['notification_link_course','notification_resume_purchase','notification_news_courses']);
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('type_user')->default(0)->after('id');
        });

        DB::table('users')->where('role_id', 31)->update([
            'type_user' => \App\User::CUSTOMER
        ]);
        DB::table('users')->where('role_id', 21)->update([
            'type_user' => \App\User::TEACHER
        ]);
        DB::table('users')->where('role_id', 1)->update([
            'type_user' => \App\User::ADMIN
        ]);
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
