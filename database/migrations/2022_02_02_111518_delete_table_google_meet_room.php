<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTableGoogleMeetRoom extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::getDriverName() !== 'sqlite') {
            if (Schema::hasColumn('google_meet_rooms', 'user_id')) {
                Schema::table('google_meet_rooms', function (Blueprint $table) {
                    $table->dropForeign([ 'user_id' ]);
                    $table->dropColumn([ 'user_id' ]);
                });
            }
            if (Schema::hasColumn('google_meet_rooms', 'promotion_id')) {
                Schema::table('google_meet_rooms', function (Blueprint $table) {
                    $table->dropForeign([ 'promotion_id' ]);
                    $table->dropColumn([ 'promotion_id' ]);
                });
            }
        }
        Schema::dropIfExists('google_meet_rooms');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         (new CreateGoogleMeetRoomsTable())->up();
    }
}
