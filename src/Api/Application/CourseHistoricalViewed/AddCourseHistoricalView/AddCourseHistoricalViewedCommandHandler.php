<?php

namespace Mi-empresa\Api\Application\CourseHistoricalViewed\AddCourseHistoricalView;

use Mi-empresa\Api\Domain\Repository\CourseHistoricalViewedRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class AddCourseHistoricalViewedCommandHandler implements CommandHandler
{
    public function __construct(private CourseHistoricalViewedRepository $courseHistoricalViewedRepository)
    {
    }

    public function __invoke(AddCourseHistoricalViewedCommand $addCourseHistoricalViewedCommand)
    {
        $dataFind = [
            'user_id' => $addCourseHistoricalViewedCommand->userId()->value(),
            'course_id' => $addCourseHistoricalViewedCommand->courseId()->value()
        ];
        $courseHistoricalViewed = $this->courseHistoricalViewedRepository->firstOrAdd($dataFind);
        if (isset($courseHistoricalViewed)) {
            $dataUpdate = [
                'counter' => $courseHistoricalViewed->counter + 1
            ];
            $this->courseHistoricalViewedRepository->updateOrCreate($dataFind, $dataUpdate);
        }
    }
}
