<?php

namespace Mi-empresa\Api\Application\Reviews\CalculateReviewsCourse;

use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class CalculateReviewsCourseCommandHandler implements CommandHandler
{
    public function __construct(private CourseReviewsRepository $courseReviewsRepository, private CoursesRepository $coursesRepository)
    {
    }

    public function __invoke(CalculateReviewsCourseCommand $calculateReviewsCourseCommand)
    {
        $course = $this->courseReviewsRepository->getByColumn('course_id', $calculateReviewsCourseCommand->courseId()->value());
        $courseReviews1 = $course->getAvgColumn('rating1');
        $courseReviews2 = $course->getAvgColumn('rating2');
        $courseReviews3 = $course->getAvgColumn('rating3');
        $courseReviews4 = $course->getAvgColumn('rating4');
        $countTotal = $course->countTotal();

        if (isset($courseReviews1, $courseReviews2, $courseReviews3, $courseReviews4)) {
            $avg_reviews = ($courseReviews1 + $courseReviews2 + $courseReviews3 + $courseReviews4) / 4;
            $this->coursesRepository->updateById($calculateReviewsCourseCommand->courseId(), [
                'total_reviews' => (string)$countTotal,
                'avg_reviews' => (string)$avg_reviews,
            ]);
        } else {
            $this->coursesRepository->updateById($calculateReviewsCourseCommand->courseId(), [
                'total_reviews' => 0,
                'avg_reviews' => 0
            ]);
        }
    }
}
