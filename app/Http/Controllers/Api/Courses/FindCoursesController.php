<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mi-empresa\Api\Application\Courses\FindCourses\FindCoursesQuery;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

class FindCoursesController extends Controller
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function index(Request $request, CdnAdapter $cdnAdapter): JsonResponse
    {
        $baseUrl = $cdnAdapter->base();

        $activeCourses = true;
        if (isset($request->active_courses)) {
            $activeCourses = false;
        }

        $limit = 12;
        $minCourses = 0;
        if ($request->has('filterRecommended')) {
            $limit = 4;
            $minCourses = 4;
        }

        $filters = $request->get('filter', []);

        $courses = $this->queryBus->ask(
            new FindCoursesQuery($filters, $limit, $activeCourses, $minCourses)
        );

        return response()->json(['courses' => $courses, 'url' => $baseUrl]);
    }
}
