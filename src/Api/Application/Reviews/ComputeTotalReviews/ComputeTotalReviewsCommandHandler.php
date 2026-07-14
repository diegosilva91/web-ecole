<?php

namespace Lifecole\Api\Application\Reviews\ComputeTotalReviews;

use Lifecole\Api\Application\Reviews\CalculateReviewsCourse\CalculateReviewsCourseCommand;
use Lifecole\Api\Application\Reviews\CalculateReviewsTeacher\CalculateReviewsTeachersCommand;
use Lifecole\Api\Domain\Repository\CourseReviewsRepository;
use Lifecole\Event\Domain\Bus\Command\CommandBus;
use Lifecole\Event\Domain\Bus\Command\CommandHandler;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

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
