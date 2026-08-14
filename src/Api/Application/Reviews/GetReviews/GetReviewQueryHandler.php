<?php

namespace Mi-empresa\Api\Application\Reviews\GetReviews;

use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetReviewQueryHandler implements QueryHandler
{
    public function __construct(private CourseReviewsRepository $courseReviewsRepository)
    {
    }

    public function __invoke(GetReviewQuery $getReviewQuery)
    {
        return $this->courseReviewsRepository->getByColumn(
            'user_id',
            $getReviewQuery->userId()->value()
        )
            ->getByColumn('course_id', $getReviewQuery->courseId()->value())
            ->retrieveFromQuery();
    }
}
