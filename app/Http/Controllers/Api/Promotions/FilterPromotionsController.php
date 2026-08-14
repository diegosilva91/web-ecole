<?php

namespace App\Http\Controllers\Api\Promotions;

use App\Promotion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Api\Domain\Helper\FillSubcategories;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilterPromotionsController
{
    public string $url;

    public function __construct(CdnAdapter $cdnAdapter)
    {
        $this->url = $cdnAdapter->base();
    }

    public function filter(Request $request, FillSubcategories $fillSubcategories): JsonResponse
    {
        $filters = $request->get('filter', null);
        if (Arr::has($filters, 'user.id')) {
            if (Auth::check() || Auth::guard('api')->check()) {
                if (!Auth::user()->hasRole('admin') && (int)$filters['user.id'] !== Auth::id()) {
                    return response()->json(['error' => 'Unauthorized'], 419);
                }
            } else {
                return response()->json(['error' => 'Unauthorized only auth session'], 419);
            }
        }
        if (Arr::has($filters, 'userPromotionPurchases.id')) {
            if (Auth::check() || Auth::guard('api')->check()) {
                if (!Auth::user()->hasRole('admin') && (int)$filters['userPromotionPurchases.id'] !== Auth::id()) {
                    return response()->json(['error' => 'Unauthorized'], 419);
                }
            } else {
                return response()->json(['error' => 'Unauthorized only auth session'], 419);
            }
        }

        $active_promotions = $request->get('active_promotions');
        $promotions = QueryBuilder::for(Promotion::class)->allowedFilters([AllowedFilter::scope('search_by'), AllowedFilter::exact('user.id'), 'daily', AllowedFilter::exact('course_id'), AllowedFilter::exact('starts_after')->scope('starts_after'), AllowedFilter::exact('start_at_end_at')->scope('start_at_end_at'), AllowedFilter::scope('starts_after_hour'), AllowedFilter::exact('id'), AllowedFilter::exact('between_now_end_at'), AllowedFilter::exact('between_star_at_now'), AllowedFilter::exact('userPromotionPurchases.id')])
            ->with(['courses', 'course', 'userAssistant'])
            ->allowedIncludes(['courses', 'promotionPurchases', 'usersPromotionPurchases', 'userPromotionPurchases'])
            ->when(isset($filters['userPromotionPurchases.id']), function ($query) use ($filters) {
                return $query->whereHas('courses')->whereHas('userPromotionPurchases', function ($query) use ($filters) {
                    return $query->where(['users.id' => $filters['userPromotionPurchases.id']]);
                });
            })
            ->withCount('promotionPurchases as students_total')->IsPurchasable($request->get('is_purchasable'))->ActivePromotions($active_promotions)->orderby('start_at', 'desc')
            ->when($request->has('FilterByStudents'), function ($query) {
                return $query->cursor();
//                return $query->with('courses')->whereHas('courses',function ($queryCourses){
////                    dd($queryCourses->select('students_max')->cursor()->get());
//                    return $queryCourses->whereHas ( 'promotionPurchases',function($query){
//                        return $query;} ,'<',\DB::raw('`courses`.`students_max`'));
//                },'>=',1);
            })
            ->when(!$request->has('FilterByStudents'), function ($query) {
                return $query->paginate(5);
            });

        $promotions->map(function ($value) use ($request, $fillSubcategories) {
            if (empty($value->courses)) {
                $value->courses = [];
            } else {
                $fillSubcategories->apply($value->courses);
            }

            $value->completed = $value->end_at <= now()->format('Y-m-d');
            $value->is_next = $value->start_at >= now()->format('Y-m-d');
            $value->actual = $value->start_at <= now()->format('Y-m-d') && $value->end_at >= now()->format('Y-m-d');
            $value->next_at = Carbon::parse($value->start_at);//:Carbon::parse($value->end_at)->format('Y-m-d H:m:s');
            //If duration is defined and next_at is diff to end_at search next class
            //Avoid iterate if promotion is actual
            if (isset($value->courses->duration) && $value->actual) {
                $week = 1;
                while ($value->next_at < now()) {
                    $value->next_at = $value->next_at->addWeek();
                    $week += 1;
                }
            }
            $value->next_at = $value->next_at->toDateTimeString();
        });
        if (!empty($request->get('FilterByStudents', null))) {
            $promotions = $promotions->filter(function ($promotion) {
                if (isset($promotion->courses->students_max)) {
                    return $promotion->courses->students_max > $promotion->promotionPurchases->count();
                }
            });
            if ($request->get('pages', false)) {
                return response()->json(['promotions' => $promotions]);
            } else {
                $page = $request->get('page', 1);
                $offset = ($page - 1) * 5;
                $promotions = new LengthAwarePaginator(
                    array_slice($promotions->toArray(), $offset, 5), //items
                    count($promotions), //total
                    5,
                    $request->get('page', 1), //current_page
                    [
                        'path' => $request->url(),
                        'query' => $request->query()
                    ]
                );
            }
        }
        return response()->json(['url' => $this->url, 'promotions' => $promotions]);
    }
}
