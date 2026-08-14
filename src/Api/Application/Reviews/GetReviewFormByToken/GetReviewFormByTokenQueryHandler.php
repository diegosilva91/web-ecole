<?php

namespace Mi-empresa\Api\Application\Reviews\GetReviewFormByToken;

use App\Exceptions\DataTokenReviewException;
use Mi-empresa\Api\Application\Reviews\GetReviews\GetReviewQuery;
use Mi-empresa\Api\Application\Reviews\GetTokenReviewForm\GetTokenReviewsFormQuery;
use Mi-empresa\Api\Domain\Helper\DecryptTokenReviewsForm;
use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class GetReviewFormByTokenQueryHandler implements QueryHandler
{
    public function __construct(
        private QueryBus $queryBus,
        private CoursesRepository $coursesRepository,
        private DecryptTokenReviewsForm $decryptTokenReviewsForm
    ) {
    }

    public function __invoke(GetReviewFormByTokenQuery $getReviewFormByTokenQuery): ReviewForm
    {
        $token = $getReviewFormByTokenQuery->getToken();
        $dataFromToken = $this->getDataReviewFromSafeToken($token);
        $courseId = CourseId::create($dataFromToken['course_id']);
        $userId = UserId::create($dataFromToken['user_id']);
        if (!$this->checkDataFromToken($courseId, $userId)) {
            throw new DataTokenReviewException('Invalid payload courseId and userId');
        }
        if ($this->checkReviewExist($courseId, $userId)) {
            throw new DataTokenReviewException('Course review exist');
        }
        $course_id = CourseId::create($dataFromToken['course_id']);
        $course = $this->coursesRepository->withRelation('courseUsers')->findById($course_id);

        return new ReviewForm(
            $course_id,
            UserId::create($dataFromToken['user_id']),
            $course->title,
            $course->courseUsers
        );
    }

    private function getDataReviewFromSafeToken(string $token): array
    {
        return $this->decryptTokenReviewsForm->dataFromToken($token);
    }

    private function checkDataFromToken($courseId, $userId): bool
    {
        $data_token = $this->queryBus->ask(new GetTokenReviewsFormQuery($courseId, $userId));
        return ($data_token['course']->id === $courseId->value());
    }

    private function checkReviewExist($courseId, $userId): bool
    {
        $review = $this->queryBus->ask(new GetReviewQuery($courseId, $userId));
        if (isset($review) && count($review) > 0) {
            return true;
        }
        return false;
    }
}
