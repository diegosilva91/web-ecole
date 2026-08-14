<?php

namespace App\Http\Controllers\Api\Reviews;

use App\CourseReviews;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use function response;

class CourseReviewsController extends Controller
{
    public function index(CdnAdapter $cdnAdapter): JsonResponse
    {
        $courseReviews = QueryBuilder::for(CourseReviews::class)
            ->where('is_visible', '1')
            ->allowedFilters(AllowedFilter::exact('course_id'), AllowedFilter::exact('user_id'))
            ->allowedIncludes(['course', 'user'])
            ->defaultSort('created_at')
            ->allowedSorts('created_at', 'updated_at')
            ->paginate(5);
        return response()->json(['courseReviews' => $courseReviews, 'url' => $cdnAdapter->base()], 200);
    }
}
