<?php

namespace Mi-empresa\Api\Application\Reviews\CalculateReviewsTeacher;

use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Api\Domain\Repository\TeachersRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class CalculateReviewsTeachersCommandHandler implements CommandHandler
{
    private CourseReviewsRepository $courseReviewsRepository;
    private TeachersRepository $teachersRepository;

    public function __construct(CourseReviewsRepository $courseReviewsRepository, TeachersRepository $teachersRepository)
    {
        $this->courseReviewsRepository = $courseReviewsRepository;
        $this->teachersRepository = $teachersRepository;
    }

    public function __invoke(CalculateReviewsTeachersCommand $calculateReviewsTeachersCommand)
    {
        $course = $this->courseReviewsRepository->getByColumn('teacher_id', $calculateReviewsTeachersCommand->userId()->value());
        $courseReviews1 = $course->getAvgColumn('rating1');
        $courseReviews2 = $course->getAvgColumn('rating2');
        $courseReviews3 = $course->getAvgColumn('rating3');
        $courseReviews4 = $course->getAvgColumn('rating4');
        $countTotal = $course->countTotal();

        if (isset($courseReviews1, $courseReviews2, $courseReviews3, $courseReviews4)) {
            $punctuation = ($courseReviews1 + $courseReviews2 + $courseReviews3 + $courseReviews4) / 4;
            $this->teachersRepository->updateByColumn('user_id', $calculateReviewsTeachersCommand->userId()->value(), [
                'rating1' => (float) $courseReviews1,
                'rating2' => (float) $courseReviews2,
                'rating3' => (float) $courseReviews3,
                'rating4' => (float) $courseReviews4,
                'total_reviews' => (int) $countTotal,
                'avg_reviews' => (float) $punctuation,
            ]);
        }
    }
}
