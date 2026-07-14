<?php

namespace App\Http\Controllers\Api\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoursesSearchRequest;
use Lifecole\Api\Application\Courses\CoursesSearch\CoursesSearchQuery;
use Lifecole\Api\Application\Courses\CoursesSearchTag\CoursesSearchTagQuery;
use Lifecole\Api\Domain\Adapter\CdnAdapter;
use Lifecole\Api\Domain\DTO\CoursesSearch;
use Lifecole\Event\Domain\Bus\Query\QueryBus;

class CoursesSearchController extends Controller
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function index(CoursesSearchRequest $request, CdnAdapter $cdnAdapter)
    {
        $baseUrl = $cdnAdapter->base();
        $courseDTO = CoursesSearch::createFromRequest(
            $request->get('type_course', Course::TYPE_INTENSIVE),
            $request->get('areas'),
            $request->get('categories'),
            $request->get('specializations'),
            $request->get('tag'),
            $request->get('age'),
            $request->get('search'),
            $request->get('page'),
            null
        );
        if ($courseDTO->isJustTag()) {
            $courses = $this->queryBus->ask(
                new CoursesSearchTagQuery($courseDTO)
            );
        } else {
            if ($courseDTO->typeCourse() === Course::TYPE_INTENSIVE) {
                $courseDTO->setLimit(12);
            } else {
                $courseDTO->setLimit(8);
            }
            $courses = $this->queryBus->ask(
                new CoursesSearchQuery($courseDTO)
            );
        }

        return response()->json(['courses' => $courses, 'url' => $baseUrl]);
    }
}
