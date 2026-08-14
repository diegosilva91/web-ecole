<?php

namespace Mi-empresa\Api\Application\Courses\CoursesSearchTag;

use App\Course;
use Mi-empresa\Api\Domain\Repository\SearcherCoursesRepository;

class CoursesSearchTagQueryHandler
{
    public function __construct(private SearcherCoursesRepository $searcherCoursesRepository)
    {
    }

    public function __invoke(CoursesSearchTagQuery $coursesSearchQuery): array
    {
        $count = 0;
        if (empty($coursesSearchQuery->coursesSearch()->typeCourse())) {
            $coursesSearchQuery->coursesSearch()->setPage(null);

            $coursesSearchQuery->coursesSearch()->setLimit($this->getLimits(Course::TYPE_INTENSIVE));
            $coursesSearchQuery->coursesSearch()->setTypeCourse(Course::TYPE_INTENSIVE);
            $items = $this->searcherCoursesRepository->search($coursesSearchQuery->coursesSearch());
            $count += count($items);
            $course[] = $items;

            $coursesSearchQuery->coursesSearch()->setTypeCourse(Course::TYPE_TRAJECTORY);
            $coursesSearchQuery->coursesSearch()->setLimit($this->getLimits(Course::TYPE_TRAJECTORY));
            $items = $this->searcherCoursesRepository->search($coursesSearchQuery->coursesSearch());
            $count += count($items);
            $course[] = $items;

            $coursesSearchQuery->coursesSearch()->setTypeCourse(Course::TYPE_CAMPUS);
            $coursesSearchQuery->coursesSearch()->setLimit($this->getLimits(Course::TYPE_CAMPUS));
            $items = $this->searcherCoursesRepository->search($coursesSearchQuery->coursesSearch());
            $count += count($items);
            $course[] = $items;
        } else {
            $limit = $this->getLimits($coursesSearchQuery->coursesSearch()->typeCourse());
            $coursesSearchQuery->coursesSearch()->setLimit($limit);
            $items = $this->searcherCoursesRepository->search($coursesSearchQuery->coursesSearch());
            $count += count($items);
            $course[] = $items;
        }
        return ['items' => $course, 'count' => $count];
    }

    private function getLimits(int $type_course): int
    {
        return match ($type_course) {
            Course::TYPE_TRAJECTORY => 2,
            default => 3,
        };
    }
}
