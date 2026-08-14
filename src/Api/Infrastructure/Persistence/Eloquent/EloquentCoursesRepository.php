<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\Course;
use Illuminate\Support\Arr;
use Mi-empresa\Api\Application\Courses\FindCourses\FindCoursesQuery;
use Mi-empresa\Api\Domain\Helper\AddPriceHour;
use Mi-empresa\Api\Domain\Helper\FillSubcategories;
use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EloquentCoursesRepository extends EloquentRepository implements CoursesRepository
{
    private AddPriceHour $addPriceHour;
    private FillSubcategories $fillSubcategories;

    public function __construct(AddPriceHour $addPriceHour, FillSubcategories $fillSubcategories)
    {
        parent::__construct();
        $this->addPriceHour = $addPriceHour;
        $this->fillSubcategories = $fillSubcategories;
    }

    public function updateById(CourseId $courseId, array $dataFill)
    {
        $model = $this->model->find($courseId->value());
        $model->update($dataFill);
    }

    public function getPromotionByUserIdThroughPromotionPurchase(UserId $user_id): object
    {
        $this->model = $this->model->whereHas('promotions', function ($query) use ($user_id) {
            return $query->whereHas('promotionPurchases', function ($query) use ($user_id) {
                return $query->where('user_id', $user_id->value());
            });
        });
        return $this;
    }

    public function withRelation(string $relation): object
    {
        $this->model = $this->model->with($relation);
        return $this;
    }

    public function findById(CourseId $courseId): object|null
    {
        return $this->model->find($courseId->value());
    }

    public function find(FindCoursesQuery $findCoursesQuery): object
    {
        $filters = $findCoursesQuery->filters();

        $courses = QueryBuilder::for(Course::class)
            ->allowedFields(
                [
                    'users.id', 'users.name', 'users.avatar',
                    'id',
                    'courses_category_id',
                    'title',
                    'students_max',
                    'students_min',
                    'student_ages_max',
                    'student_ages_min',
                    'avg_reviews',
                    'total_reviews',
                    'cover_image_mobile',
                    'cover_image',
                    'price_total',
                    'discount',
                    'duration',
                    'session',
                    'session_time',
                    'slug',
                    'course_specialization_id',
                    'categories.id',
                    'categories.title',
                    'categories.slug',
                ]
            )
            ->allowedFilters(
                [
                    AllowedFilter::scope('search_by'),
                    'title',
                    'daily',
                    'id',
                    'level',
                    AllowedFilter::exact('is_subscription'),
                    AllowedFilter::exact('subtype_course'),
                    AllowedFilter::exact('type_course'),
                    AllowedFilter::exact('courses_category_id'),
                    AllowedFilter::exact('duration'),
                    AllowedFilter::scope('starts_after'),
                    AllowedFilter::scope('starts_after_hour'),
                    AllowedFilter::scope('price_between'),
                    AllowedFilter::scope('categories_name'),
                    AllowedFilter::exact('student_ages_min', 'student_ages_max')->scope('age_between'),
                    AllowedFilter::exact('promotion_purchase_user_id')->scope('promotion_purchase_user_id'),
                    AllowedFilter::exact('promotions_state')->scope('promotions_state'),
                    AllowedFilter::exact('skills.skill_name')
                ]
            )
            ->allowedIncludes([ 'categoriesNew', 'specializations', 'categories', 'courseUsers', 'promotions', 'courseReviews', 'requirements', 'promotionPurchase', 'skills', 'prices' ])
            ->allowedSorts('promotion_purchase_count')
            ->when(isset($filters[ 'type_course' ]) && $filters[ 'type_course' ] ? : false === '1', function ($query) {
                $query->with([ 'pricesEnrollment' => function ($query) {
                    return $query;
                } ]);
            })
            ->when(isset($filters[ 'promotion_purchase_user_id' ]), function ($query) {
                $query->with([ 'promotionPurchases' => function ($query) {
                    return $query;
                } ]);
            })
            ->IsPurchasable()->ActiveCourses($findCoursesQuery->activeCourses())->ListCoursesFilters(true)
            ->paginate($findCoursesQuery->limit());

        if ($findCoursesQuery->hasMinCourses() && count($courses) < $findCoursesQuery->minCourses()) {
            $courses = Course::with([ 'categories', 'promotions', 'courseReviews', 'requirements', 'promotionPurchase', 'skills' ])
                ->ActiveCourses($findCoursesQuery->activeCourses())->ListCoursesFilters(true)
                ->SkillsName($filters[ 'skills.skill_name' ])->take($findCoursesQuery->minCourses())->paginate($findCoursesQuery->minCourses());

            if (count($courses) < ($findCoursesQuery->minCourses() - 1)) {
                $courses = Course::with([ 'categories', 'promotions', 'courseReviews', 'requirements', 'promotionPurchase', 'skills' ])
                    ->ActiveCourses($findCoursesQuery->activeCourses())->ListCoursesFilters(true)
                    ->whereHas('skills')->take($findCoursesQuery->minCourses())->paginate($findCoursesQuery->minCourses());
            }
        }

        $courses->map(function ($value) use ($filters) {
            $value->newLink = optional($value)->getLink();
            $promotions = $value->promotions()->IsPurchasable(true)->ActivePromotions(true)->get();
            if (count($promotions) > 0) {
                $value->first_promotion = $promotions->firstWhere('start_at', '>=', now()->format('Y-m-d'));
                $promotions->filter(function ($promotion) {
                    if (isset($promotion->courses->students_max) && isset($promotion->promotionPurchases)) {
                        return $promotion->courses->students_max > $promotion->promotionPurchases->count();
                    }
                });
                if (isset($filters[ 'type_course' ]) && $filters[ 'type_course' ] ? : false === '1') {
                    $value->available_first_promotion = $value->first_promotion;
                    $promotions = $value->promotions()->ActivePromotions(true)->get();
                    $value->last_promotion = $promotions->last();
                    $value->first_promotion = $promotions->first();
                    if (count($value->pricesEnrollment) > 0) {
                        $value->price_enrollment = $value->pricesEnrollment->first();
                    } else {
                        $value->price_enrollment = 0;
                    }
                }
            }
        });

        if (isset($filters[ 'promotion_purchase_user_id' ])) {
            $courses->map(function ($value) use ($filters) {
                $value->my_promotions = $value->promotions->filter(function ($promotion) use ($filters) {
                    return $promotion->whereHas('promotionPurchases', function ($query) use ($filters) {
                        return $query->where([ 'user_id' => $filters[ 'promotion_purchase_user_id' ] ]);
                    });
                });
                $value->completed = empty($value->my_promotions);
            });
        }

        $this->addPriceHour->apply($courses);
        $this->fillSubcategories->apply($courses);

        return $courses;
    }

    public function featuredCourses(int $limit, UserId $userId = null, ?array $filters = null): object
    {
        if (empty($filters[ 'type_course' ])) {
            $filters[ 'type_course' ] = Course::SUBTYPE_NOTHING;
        }

        $featuredCourses = Course::with([ 'categories', 'promotions' ])
            ->when(isset($filters[ 'type_course' ]) && $filters[ 'type_course' ] ? : false === '1', function ($query) {
                $query->with([ 'pricesEnrollment' => function ($query) {
                    return $query;
                } ]);
            })->where('type_course', $filters[ 'type_course' ])->ActiveCourses(true)->ListCoursesAllFeatured(true);

        if (isset($userId)) {
            $is_favorite = Course::JoinFavouritesCourseFilterByUserFavourites($userId->value())->ListCoursesAllFeatured(true);
            $featuredCourses
                ->joinSub($is_favorite, 'favorites', function ($join) {
                    $join->on('courses.id', '=', 'favorites.id');
                });
        }

        $featuredCourses = $featuredCourses->paginate($limit);
        if ($featuredCourses) {
            $featuredCourses->map(function ($value) use ($filters) {
                $promotions = $value->promotions()->IsPurchasable(true)->ActivePromotions(true)->cursor();
                $promotions = $promotions->filter(function ($promotion) {
                    if (isset($promotion->courses) && isset($promotion->promotionPurchases)) {
                        return ($promotion->courses->students_max > $promotion->promotionPurchases->count());
                    }
                });
                $value->first_promotion = $promotions->firstWhere('start_at', '>=', now()->format('Y-m-d'));
                if (isset($filters[ 'type_course' ])) {
                    if ($filters[ 'type_course' ] ? : false === '1') {
                        $value->availabe_first_promotion = $value->first_promotion;
                        $promotions = $value->promotions()->ActivePromotions(true)->get();
                        $value->last_promotion = $promotions->last();
                        $value->first_promotion = $promotions->first();
                        if (count($value->pricesEnrollment) > 0) {
                            $value->price_enrollment = $value->pricesEnrollment->first();
                        } else {
                            $value->price_enrollment = 0;
                        }
                    }
                }
            });
            $featuredCourses->map(function ($value) use ($filters) {
                $value->newLink = optional($value)->getLink();
            });
            $this->addPriceHour->apply($featuredCourses);
            $this->fillSubcategories->apply($featuredCourses);
        }

        return $featuredCourses;
    }

    public function getCourseByArrayParameters(array $parameters)
    {
        $this->model = $this->model
            ->where("courses.slug", $parameters['courses.slug'])
            ->when(array_key_exists('specialization.slug', $parameters) && isset($parameters['specialization.slug']), function ($query) use ($parameters) {
                return $query->SpecializationsName($parameters['specialization.slug']);
            })
            ->when(array_key_exists('categories.slug', $parameters) && isset($parameters['categories.slug']), function ($query) use ($parameters) {
                return $query->CategoriesName($parameters['categories.slug']);
            });

        if (Arr::has($parameters, 'visible') && $parameters['visible'] === true) {
            $this->model->ListCoursesFilters(true);
        }

        return $this->model->first();
    }

    public function getCourseByOldArrayParameters(array $parameters)
    {
        $this->model = $this->model
            ->where("courses.slug", $parameters['courses.slug'])
            ->when(array_key_exists('old_categories.slug', $parameters) && isset($parameters['old_categories.slug']), function ($query) use ($parameters) {
                return $query->whereHas('categories', function ($query) use ($parameters) {
                    return $query->where('slug', $parameters['old_categories.slug']);
                });
            });

        return $this->model->first();
    }

    public function getAll(array $relations, ?array $arguments_get, ?array $filters)
    {
        if (isset($arguments_get) && count($arguments_get) > 0) {
            return $this->model->with($relations)
                ->when(isset($filters[ 'active' ]), function ($query) use ($filters) {
                    return $query->ActiveCourses($filters[ 'active' ]);
                })
                ->when(isset($filters[ 'visible' ]), function ($query) use ($filters) {
                    return $query->where('is_visible', $filters[ 'visible' ]);
                })
                ->get($arguments_get);
        }
        return $this->model->with($relations)->get();
    }

    protected function model(): string
    {
        return Course::class;
    }
}
