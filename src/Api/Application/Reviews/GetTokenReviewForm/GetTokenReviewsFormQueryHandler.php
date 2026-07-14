<?php

namespace Lifecole\Api\Application\Reviews\GetTokenReviewForm;

use App\Exceptions\DataTokenReviewException;
use Lifecole\Api\Domain\Repository\CoursesRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

class GetTokenReviewsFormQueryHandler implements QueryHandler
{
    public function __construct(private CoursesRepository $coursesRepository, private EncryptTokenReviewsForm $getTokenReviewsForm)
    {
    }

    public function __invoke(GetTokenReviewsFormQuery $getTokenReviewsFormQuery): array
    {
        $course = $this->checkUserInsidePromotion($getTokenReviewsFormQuery->userId(), $getTokenReviewsFormQuery->courseId());
        if (empty($course)) {
            throw new DataTokenReviewException("Invalid payload courseId and userId");
        }

        return [
            'course' => $course,
            'token' => $this->createSafeToken($getTokenReviewsFormQuery->userId(), $getTokenReviewsFormQuery->courseId())
        ];
    }

    private function checkUserInsidePromotion($user_id, $course_id): object|null
    {
        return $this->coursesRepository->getPromotionByUserIdThroughPromotionPurchase($user_id)->findById($course_id);
    }

    private function createSafeToken($user_id, $course_id): string
    {
        return $this->getTokenReviewsForm->__invoke($user_id->value(), $course_id->value());
    }
}
