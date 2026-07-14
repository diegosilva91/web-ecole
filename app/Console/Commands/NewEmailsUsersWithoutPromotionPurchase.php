<?php

namespace App\Console\Commands;

use App\MailSent;
use App\Notifications\RemmindersUser;
use App\PromotionPurchase;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Lang;

class NewEmailsUsersWithoutPromotionPurchase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new_emails:send_users_without_promotions_purchase
                            {days : Days to find users without promotions purchase}
                            {--send_email= : Set true for send email. Optional}
                            {--stage= : Set stage of email job. Optional}
                            {--manual_command= : Set true for show the list of users without send emails. Optional}';

    /**
     * The console command description.
     * Install
     * php artisan  new_emails:send_users_without_promotions_purchase 5 --send_email=false --stage=1
     * php artisan  new_emails:send_users_without_promotions_purchase 10 --send_email=false --stage=2
     * php artisan  new_emails:send_users_without_promotions_purchase 15 --send_email=false --stage=3
     * php artisan  new_emails:send_users_without_promotions_purchase 5 --send_email=true --stage=1 --manual_command=false
     * php artisan  new_emails:send_users_without_promotions_purchase 10 --send_email=true --stage=2 --manual_command=false
     * php artisan  new_emails:send_users_without_promotions_purchase 15 --send_email=true --stage=3 --manual_command=false
     * @var string
     */
    protected $description = 'php artisan new_emails:send_users_without_promotions_purchase 5 --send_email=true --stage=1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = (int)$this->argument('days');
        $send_email = $this->option('send_email') ?? 'false';
        $stage = $this->option('stage') ?? 1;
        $manual_command = $this->option('manual_command') ?? 'false';

        $subject = $this->getTemplateTitle($days);
        /** It's false setup mailSent for all users existing, it's make that users have the process ready in stage 1,2,3*/
        if ($send_email === 'false') {
            $typeEmail = match ($days) {
                5 => MailSent::REMINDER_PROMOTION_NEW_USERS_5_DAYS,
                10 => MailSent::REMINDER_PROMOTION_NEW_USERS_10_DAYS,
                default => MailSent::REMINDER_PROMOTION_NEW_USERS_15_DAYS,
            };

            /** Users without promotionPurchase and mailSent*/
            $users = User::whereDoesntHave('promotionPurchaseALl', function ($query) {
                $query->where('paid', PromotionPurchase::PAID_PAID);
            })
                ->when($stage !== 1, function ($query) use ($days, $typeEmail) {
                    return $query->whereDoesntHave('mailSent', function ($query) use ($days, $typeEmail) {
                        return $query->where([ 'type' => $typeEmail ]);
                    });
                })
                ->when($stage === 1, function ($query) {
                    return $query->doesntHave('mailSent');
                })->whereBetween('created_at', [ now()->startOfDay()->subDays($days), now()->endOfDay()->subDays($days) ])
                ->get();

            dump(count($users));
            $users->each(function ($user) use ($stage, $subject, $days, $typeEmail) {
                dump([
                    'user_id' => (int) $user->id,
                    'stage' => (int) $stage,
                    'status' => 'succeeded',
                    'process' => 'emails:send_users_without_promotions_purchase'
                ]);
                dump([
                    'user_id' => $user->id,
                    'subject' => $subject,
                    'type' => $typeEmail,
                ]);
            });
        } elseif ($send_email === 'true') {
            $typeEmail = match ($days) {
                5 => MailSent::REMINDER_PROMOTION_NEW_USERS_5_DAYS,
                10 => MailSent::REMINDER_PROMOTION_NEW_USERS_10_DAYS,
                default => MailSent::REMINDER_PROMOTION_NEW_USERS_15_DAYS,
            };
            $users = User::whereDoesntHave('promotionPurchaseALl', function ($query) {
                $query->where('paid', PromotionPurchase::PAID_PAID);
            })->whereDoesntHave('mailSent', function ($query) use ($days, $typeEmail) {
                return $query->where([ 'type' => $typeEmail ]);
            })->whereBetween('created_at', [ now()->startOfDay()->subDays($days), now()->endOfDay()->subDays($days) ])
                ->get();

            dump("Stage " . $stage, count($users));
            /**Send users without mailSent for stage set before**/
            $users->each(function ($user) use ($stage, $days, $manual_command, $subject, $typeEmail) {
                if ($manual_command === 'true') {
                    dump($user->id, optional($user)->email, count(optional($user)->promotionPurchaseALl->filter(function ($promotionPurchaseALl) {
                        return $promotionPurchaseALl->paid === PromotionPurchase::PAID_PAID;
                    })));
                } else {

                    dump($user->id, optional($user)->email);
                    sleep(1);
                    $user->mailSent()->create([
                        /*'subject' => $this->ensureUtf8($subject),*/
                        'type' => $typeEmail
                    ]);
                    $this->sendEmailToUser($days, $user);
                }
            });
        }
        return 0;
    }

    /**
     * @param $days
     * @param User $user
     */
    private function sendEmailToUser($days, User $user)
    {
        $user->notify(new RemmindersUser('emails.mail-' . $days . 'days', $user));
    }

    private function getTemplateTitle($day)
    {
        return Lang::get('emails.mail-' . $day . 'days' . '.subject');
    }

    public function ensureUtf8($value)
    {
        $encoding = mb_detect_encoding($value, [ 'UTF-8', 'ISO-8859-1' ]); // Add more encodings to support here

        if ($encoding !== 'UTF-8') {
            $value = mb_convert_encoding($value, 'UTF-8', $encoding);
        }
        $value =  preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $value);
        return $value;
    }
}
