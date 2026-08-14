<?php

namespace App\Listeners;

use App\Notifications\PromotionEndAtUsers;
use Mi-empresa\Api\Application\Reviews\GetTokenReviewForm\GetTokenReviewsFormQuery;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Shared\Domain\Event\UserHasFinishedPromotion;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

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
