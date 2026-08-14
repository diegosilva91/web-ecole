<?php

namespace Mi-empresa\Api\Application\Reviews\AddReview;

use App\Jobs\ComputeReviews;
use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class AddReviewCommandHandler implements CommandHandler
{
    public function __construct(private CourseReviewsRepository $courseReviewsRepository)
    {
    }

    public function __invoke(AddReviewCommand $addReviewCommand)
    {
        $dataFind = [
            'user_id' => ($addReviewCommand->userId())->value(),
            'course_id' => ($addReviewCommand->courseId())->value(),
            'teacher_id' => ($addReviewCommand->teacherId())->value(),
        ];
        $dataUpdate = [
            'rating1' => $addReviewCommand->rating1(),
            'rating2' => $addReviewCommand->rating2(),
            'rating3' => $addReviewCommand->rating3(),
            'rating4' => $addReviewCommand->rating4(),
            'opinion' => $addReviewCommand->opinion(),
        ];
        $this->courseReviewsRepository->updateOrCreate($dataFind, $dataUpdate);

        ComputeReviews::dispatch($addReviewCommand->courseId(), $addReviewCommand->teacherId());
    }
}
