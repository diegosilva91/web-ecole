<?php

namespace App\Http\Controllers\Api\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mi-empresa\Api\Application\Courses\GetFeaturedCourses\GetFeaturedCoursesQuery;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class FeaturedCoursesController extends Controller
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function index(Request $request, CdnAdapter $cdnAdapter)
    {
        $baseUrl = $cdnAdapter->base();

        $limit = 4;
        $userId = null;
        if (Auth::check()) {
            $userId = UserId::create(Auth::id());
        }
        $filters = $request->get('filter', []);

        $featuredCourses = $this->queryBus->ask(
            new GetFeaturedCoursesQuery($limit, $userId, $filters)
        );
        return response()->json(['courses' => $featuredCourses, 'url' => $baseUrl]);
    }
}
