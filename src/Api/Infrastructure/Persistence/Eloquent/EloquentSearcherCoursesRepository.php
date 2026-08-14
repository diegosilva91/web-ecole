<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\Course;
use App\Http\Resources\CoursesSearchResource;
use App\Http\Resources\PaginatedResource;
use Mi-empresa\Api\Domain\DTO\CoursesSearch;
use Mi-empresa\Api\Domain\Helper\AddPriceHour;
use Mi-empresa\Api\Domain\Helper\FillSubcategories;
use Mi-empresa\Api\Domain\Repository\SearcherCoursesRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentSearcherCoursesRepository extends EloquentRepository implements SearcherCoursesRepository
{
    private AddPriceHour $addPriceHour;
    private FillSubcategories $fillSubcategories;

    public function __construct(AddPriceHour $addPriceHour, FillSubcategories $fillSubcategories)
    {
        parent::__construct();
        $this->addPriceHour = $addPriceHour;
        $this->fillSubcategories = $fillSubcategories;
    }

    public function search(CoursesSearch $coursesSearch)
    {
        $filters = $coursesSearch->toArray();
        $courses = $this->model
            ->with('promotionPurchase')
            ->when(isset($filters[ 'areas' ]), function ($query) use ($filters) {
                return $query->AreasName($filters[ 'areas' ]);
            })
            ->when(isset($filters[ 'specializations' ]), function ($query) use ($filters) {
                return $query->SpecializationsName($filters[ 'specializations' ]);
            })
            ->when(isset($filters[ 'categories' ]), function ($query) use ($filters) {
                return $query->CategoriesName($filters[ 'categories' ]);
            })
            ->when(isset($filters[ 'type_course' ]), function ($query) use ($filters) {
                return $query->where('type_course', $filters[ 'type_course' ]);
            })
            ->when(isset($filters[ 'age' ]) && count($filters[ 'age' ]) > 0, function ($query) use ($filters) {
                return $query->where(function ($query) use ($filters) {
                    foreach ($filters[ 'age' ] as $ages) {
                        $age = explode('-', $ages);
                        $query->orWhere(function ($query) use ($age) {
                            $query->AgeBetween($age[ 1 ], $age[ 0 ]);
                        });
                    }
                });
            })
            ->when(isset($filters[ 'search' ]), function ($query) use ($filters) {
                return $query->where('courses.title', 'LIKE', '%' . $filters[ 'search' ] . '%');
            })
            ->IsPurchasable(true)
            ->where('courses.is_visible', 1)
            ->when(isset($filters[ 'tag' ]), function ($query) use ($filters) {
                $take = $filters[ 'limit' ] ?? 2;
                return $query->take($take);
            })
            ->when(isset($filters[ 'tag' ]), function ($query) use ($filters) {
                return $query->where(function ($query) use ($filters) {
                    foreach ($filters[ 'tag' ] as $tag) {
                        $query->orWhere(function ($query) use ($tag) {
                            return $query->TagsName($tag);
                        });
                    }
                });
            })
//            ->orderBy('promotion_purchase_count', 'desc')
            ->get();
//        $courses->->sortByDesc('promotionPurchase.created_at');
        if (isset($courses)) {
            $courses = $courses->sortByDesc(function ($course) {
                $count = 0;
                if (isset($course->promotionPurchase)) {
                    $count = $course->promotionPurchase->count();
                }
                return $count;
            });
        }
        $this->addPriceHour->apply($courses);
        $this->fillSubcategories->apply($courses);

        $courses->map(function ($value) use ($filters) {
            $value->first_promotion = [];
            $value->newLink = optional($value)->getLink();
            $promotions = $value->promotions()->IsPurchasable(true)->ActivePromotions(true)->get();
            if (count($promotions) > 0) {
                $promotions = $promotions->filter(function ($promotion) {
                    if (isset($promotion->courses->students_max) && isset($promotion->promotionPurchases)) {
                        return $promotion->courses->students_max > $promotion->promotionPurchases->count();
                    }
                });
                $value->first_promotion = $promotions->firstWhere('start_at', '>=', now()->format('Y-m-d'));
                if (isset($filters[ 'type_course' ]) && $filters[ 'type_course' ] ? : '0' === '1') {
                    $value->available_first_promotion = $value->first_promotion;
                    $value->last_promotion = $promotions->last();
                }
            }
        });

        if (empty($filters[ 'page' ])) {
            return CoursesSearchResource::collection($courses);
        } else {
            return new PaginatedResource($courses, CoursesSearchResource::class, $filters[ 'page' ], $filters[ 'limit' ]);
        }
    }

    protected function model(): string
    {
        return Course::class;
    }
}
