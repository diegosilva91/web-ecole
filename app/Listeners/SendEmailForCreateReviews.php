<?php

namespace App\Listeners;

use App\Notifications\PromotionEndAtUsers;
use Lifecole\Api\Application\Reviews\GetTokenReviewForm\GetTokenReviewsFormQuery;
use Lifecole\Event\Domain\Bus\Query\QueryBus;
use Lifecole\Shared\Domain\Event\UserHasFinishedPromotion;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class SendEmailForCreateReviews
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function handle(UserHasFinishedPromotion $event)
    {
        $dataToken = $this->getTokenUrlReview($event->getUser()->id, $event->getCourseId());
        $event->getUser()->notify(new PromotionEndAtUsers($event->getUser(), $dataToken['course'], $dataToken['token']));
    }

    private function getTokenUrlReview(int $user_id, int $course_id)
    {
        $userId = UserId::create($user_id);
        $courseId = CourseId::create($course_id);
        return $this->queryBus->ask(
            new GetTokenReviewsFormQuery($courseId, $userId)
        );
    }
}
