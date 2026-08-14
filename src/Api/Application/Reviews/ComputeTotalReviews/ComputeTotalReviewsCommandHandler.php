<?php

namespace Mi-empresa\Api\Application\Reviews\ComputeTotalReviews;

use Mi-empresa\Api\Application\Reviews\CalculateReviewsCourse\CalculateReviewsCourseCommand;
use Mi-empresa\Api\Application\Reviews\CalculateReviewsTeacher\CalculateReviewsTeachersCommand;
use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class ComputeTotalReviewsCommandHandler implements CommandHandler
{
    public function __construct(
        private CommandBus $commandBus,
        private CourseReviewsRepository $courseReviewsRepository
    ) {
    }

    public function __invoke(ComputeTotalReviewsCommand $computeTotalReviewsCommand)
    {
        $courseReviews = $this->courseReviewsRepository->retrieveAll();
        foreach ($courseReviews as $review) {
            $courseId = CourseId::create((int) $review->course_id);
            $teacherId = UserId::create((int) $review->teacher_id);
            $this->commandBus->dispatch(new CalculateReviewsCourseCommand($courseId));
            $this->commandBus->dispatch(new CalculateReviewsTeachersCommand($teacherId));
        }
    }
}
