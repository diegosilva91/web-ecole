<?php

namespace App\Http\Controllers\Web;

use Lifecole\Api\Application\Courses\GetAllCourses\GetAllCoursesQuery;
use Lifecole\Api\Domain\Helper\SiteMap;
use Lifecole\Api\Domain\Helper\Url;
use Lifecole\Event\Domain\Bus\Query\QueryBus;

class SiteMapController
{
    private $siteMap;

    public function __construct(private QueryBus $queryBus)
    {
    }

    public function index()
    {
        $this->siteMap = new SiteMap();

        $this->addCourses();

        return response($this->siteMap->build(), 200)
            ->header('Content-Type', 'text/xml');
    }

    private function addCourses()
    {
        $filters = ['active' => true, 'visible' => true];
        $courses = $this->queryBus->ask(
            new GetAllCoursesQuery(
                ['categoriesNew', 'specializations'],
                ['course_specialization_id', 'id', 'slug', 'updated_at'],
                $filters
            )
        );

        foreach ($courses as $course) {
            $this->siteMap->add(
                Url::create($course->getLink())
                    ->lastUpdate($course->updated_at->startOfMonth()->format('c'))
                    ->frequency('never')
                    ->priority('0.6')
            );
        }
    }
}
