<?php

use App\MailSent;
use App\MailsJob;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMailSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_sent', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();
            $type = DB::connection()->getDoctrineColumn(DB::getTablePrefix() . 'users', 'id')->getType()->getName();
            if ($type == 'bigint') {
                $table->bigInteger('user_id')->unsigned()->index();
                $table->bigInteger('sender_id')->unsigned()->nullable();
            } else {
                $table->integer('user_id')->unsigned()->index();
                $table->integer('sender_id')->unsigned()->nullable();
            }
            $table->string('object_type', 60)->nullable()->default(null);
            $table->integer('object_id')->nullable()->default(null);
            $table->integer('type')->index();//object value
            $table->string('subject', 255)->nullable()->default(null)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->text('content')->nullable()->default(null)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('sender_id', 'mail_sent_sender_id_foreign')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('set null');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        $mailsJobs = MailsJob::all();
        foreach ($mailsJobs as $mailsJob) {
            if (isset($mailsJob->stage)) {
                $type = match ($mailsJob->stage) {
                    1 => MailSent::REMINDER_PROMOTION_NEW_USERS_5_DAYS,
                    2 => MailSent::REMINDER_PROMOTION_NEW_USERS_10_DAYS,
                    default => MailSent::REMINDER_PROMOTION_NEW_USERS_15_DAYS,
                };

                $mailSent = MailSent::create([
                    'type' => $type,
                    'user_id' => $mailsJob->user_id
                ]);
                $mailSent->setCreatedAt($mailsJob->created_at);
                $mailSent->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_sent');
    }
}
