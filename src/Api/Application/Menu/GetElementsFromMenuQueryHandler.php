<?php

namespace Mi-empresa\Api\Application\Menu;

use App\Course;
use Illuminate\Support\Arr;
use Mi-empresa\Api\Application\CourseArea\GetCourseArea\GetCourseAreaQuery;
use Mi-empresa\Api\Application\CourseCategory\GetCourseCategory\GetCourseCategoryQuery;
use Mi-empresa\Api\Application\CourseSpecialization\GetCourseSpecialization\GetCourseSpecializationQuery;
use Mi-empresa\Api\Application\Tag\GetCoursesTag\GetCoursesTagQuery;
use Mi-empresa\Api\Domain\DTO\CoursesSearch;
use Mi-empresa\Api\Domain\DTO\MenuTreeSelector;
use Mi-empresa\Api\Domain\Repository\MenuRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

class GetElementsFromMenuQueryHandler
{
    public function __construct(private MenuRepository $menuRepository, private QueryBus $queryBus)
    {
    }

    public function __invoke(GetElementsFromMenuQuery $getElementsFromMenuQuery): array
    {
        $response = [];
        if ($getElementsFromMenuQuery->selector() === MenuTreeSelector::TREE_NEEDS) {
            $response = [
                'filter_intensives' => $this->menuRepository->getTreeElementsIntensives(),
                'filter_trajectories' => $this->menuRepository->getTreeElementsTrajectories(),
            ];
            if ($getElementsFromMenuQuery->coursesSearch()->isJustTypeCourse()) {
                $response['optionsRequestSelected']['type_course'] = $getElementsFromMenuQuery->coursesSearch()->typeCourse();
                $response['optionsRequestSelected']['view_type'] = 'type_courses';
            } else {
                $getElementsFromMenuQuery->coursesSearch()->setTypeCourse(Course::TYPE_TRAJECTORY);
                $options_selected_trajectories = $this->menuRepository->getTitlesFromSlugsMenu(
                    $getElementsFromMenuQuery->coursesSearch(),
                    $response['filter_trajectories']
                );
                $getElementsFromMenuQuery->coursesSearch()->setTypeCourse(Course::TYPE_INTENSIVE);
                $options_selected_intensives = $this->menuRepository->getTitlesFromSlugsMenu(
                    $getElementsFromMenuQuery->coursesSearch(),
                    $response['filter_intensives']
                );
                if (count($options_selected_intensives) > count($options_selected_trajectories)) {
                    $response['optionsRequestSelected'] = $options_selected_intensives;
                } else {
                    $response['optionsRequestSelected'] = $options_selected_trajectories;
                }
                if (count($response['optionsRequestSelected']) < 4) {
                    $response['optionsRequestSelected'] = $this->fillOptionsRequested(
                        $getElementsFromMenuQuery->coursesSearch(),
                        $response['optionsRequestSelected']
                    );
                }
            }
        }

        if ($getElementsFromMenuQuery->selector() === MenuTreeSelector::MENU_NEEDS) {
            $response = [
                'menu' => $this->menuRepository->getElementsFromMenu()
            ];
        }

        return $response;
    }

    private function fillOptionsRequested(CoursesSearch $coursesSearch, $optionSelected)
    {
        $filters = $coursesSearch->toArray();

        if (isset($filters['areas']) && !Arr::has($optionSelected, ['area'])) {
            $courseArea = $this->queryBus->ask(new GetCourseAreaQuery(['title', 'slug'], ['slug' => $filters['areas']]));
            if (isset($courseArea) && count($courseArea) > 0) {
                $optionSelected['area'] = $courseArea;
            }
        }

        if (isset($filters['specializations']) && !Arr::has($optionSelected, ['specializations'])) {
            $courseSpecialization = $this->queryBus->ask(new GetCourseSpecializationQuery(['title', 'slug'], ['slug' => $filters['specializations']]));
            if (isset($courseSpecialization)) {
                $optionSelected['specializations'] = $courseSpecialization;
            }
        }

        if (isset($filters['categories']) && !Arr::has($optionSelected, ['categories'])) {
            $courseCategories = $this->queryBus->ask(new GetCourseCategoryQuery(['title', 'slug'], ['slug' => $filters['categories']]));
            if (isset($courseCategories)) {
                $optionSelected['categories'] = $courseCategories;
            }
        }

        if (isset($filters['type_course']) && !Arr::has($optionSelected, ['type_course'])) {
            $optionSelected['type_course'] = $filters['type_course'];
            $optionSelected['view_type'] = 'type_courses';
        }

        if (isset($filters['tag']) && !Arr::has($optionSelected, ['tag']) && $coursesSearch->isJustTag()) {
            $courseTag = $this->queryBus->ask(new GetCoursesTagQuery(['title', 'slug'], ['slug' => $filters['tag']]));
            if (isset($courseTag)) {
                $optionSelected['tag'][0] = $courseTag;
            } else {
                $optionSelected['tag'][0]['slug'] = $filters['tag'];
            }
            $optionSelected['view_type'] = 'type_tags';
        }
        return $optionSelected;
    }
}
