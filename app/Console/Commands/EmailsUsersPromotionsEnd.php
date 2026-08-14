<?php

namespace App\Console\Commands;

use App\Course;
use App\Promotion;
use App\User;
use Exception;
use Illuminate\Console\Command;
use Mi-empresa\Shared\Domain\Event\UserHasFinishedPromotion;

class EmailsUsersPromotionsEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:users_with_promotions_end_at
                            {--days=: Optional. Set the days before now to get promotions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Emails to Users with promotions end_at, and have promotion_purchase';

    public function handle(): int
    {
        $promotions = Promotion::with('usersPromotionPurchases')->whereHas('usersPromotionPurchases')
            ->whereBetween('end_at', [now()->subDays(1 + $this->option('days'))->startOfDay(), now()->subDays(1)->endOfDay()])->get();
        dump('Total found: ' . count($promotions));
        $promotions->each(function ($promotion) {
            try {
                dump(
                    "user with promotion end and promotion purchases ",
                    $promotion->id,
                    count(optional($promotion)->usersPromotionPurchases()->get()->unique('email'))
                );
                sleep(1);
                if (count(optional($promotion)->usersPromotionPurchases) > 0) {
                    optional($promotion)->usersPromotionPurchases()->get()->unique('email')->each(function ($user) use ($promotion) {
                        dump($promotion->id, $promotion->end_at, $user->email, count($user->promotionPurchaseALl));

                        sleep(1);
                        if (empty($promotion->course)) {
                            $course = Course::find($promotion->course_id);
                            if ($course) {
                                $this->sendEmailToUser($user, $course);
                            }

                            dump('NO SENT: user without valid course');
                        } else {
                            $this->sendEmailToUser($user, $promotion->course);
                        }
                    });
                } else {
                    dump('NO SENT: user without purchases');
                }
            } catch (Exception $e) {
                dump('NO SENT: error');
                dump($e);
            }
        });
        return 0;
    }

    private function sendEmailToUser(User $user, Course $course)
    {
        event(new UserHasFinishedPromotion($course->id, $user));
    }
}
