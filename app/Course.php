<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Course extends Model implements Feedable
{
    const TYPE_INTENSIVE = 0;
    const TYPE_TRAJECTORY = 1;
    const TYPE_CAMPUS = 2;

    const SUBTYPE_NOTHING = 0;
    const SUBTYPE_CAMPUS_SUMMER = 1;
    const SUBTYPE_CAMPUS_WINTER = 2;
    const SUBTYPE_CAMPUS_HOLY_WEEK = 3;

    protected array $joins = [];

    protected $dates = [ 'deleted_at' ];
    protected $fillable = [ 'title', 'intro', 'duration', 'session', 'sessionTime', 'level', 'description', 'objectives', 'requirements', 'price_total', 'student_ages_max', 'discount',
        'student_ages_min', 'students_min', 'students_max', 'cover_image', 'cover_image_mobile', 'cover_video',
        'is_featured', 'daily', 'is_subscription', 'total_reviews', 'avg_reviews'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->slug == "") {
                $model->slug = Str::slug($model->title, '-');
            }
            if (empty($model->is_featured)) {
                $model->is_featured = 0;
            }
        });
        static::updating(function ($model) {
            //    $model->slug = Str::slug($model->title, '-');
        });
    }
    /**********************************************************/
    /**********************************RELATIONS******************/
    /*********************************************************/

    public function getLink(bool $absolute = true): string
    {
        $link = '/es/cursos/' . optional($this->categoryNew())->slug . '/' . optional($this->specialization())->slug . '/' . optional($this)->slug;
        if ($absolute) {
            $link = env('APP_URL') . $link;
        }
        return $link;
    }

    public function descriptionTypeCourse(): string
    {
        switch ($this->type_course) {
            case self::TYPE_INTENSIVE:
                return 'Intensivo';
            case self::TYPE_TRAJECTORY:
                return 'Trayectoria';
            case self::TYPE_CAMPUS:
                return 'Campus';
        }
        return '';
    }

    public function favorites()
    {
        return $this->hasMany("App\FavouritesCourses", 'course_id')->get();
    }

    public function favoritesUsers()
    {
        // TODO edit this query and change for the join in favorites courses
        return $this->belongsToMany("App\FavouritesCourses", 'users', 'course_id', 'id', 'id');
    }

    public function category()
    {
        return $this->belongsTo("App\CoursesCategory", 'courses_category_id')->first();
    }

    public function categories()
    {
        return $this->belongsTo("App\CoursesCategory", 'courses_category_id');
    }

    public function categoryNew()
    {
        return $this->hasOneThrough('App\CourseCategory', "App\CourseSpecialization", 'id', 'id', 'course_specialization_id', 'course_category_id')->first();
    }

    public function categoriesNew()
    {
        return $this->hasOneThrough('App\CourseCategory', "App\CourseSpecialization", 'id', 'id', 'course_specialization_id', 'course_category_id');
    }

    public function specialization()
    {
        return $this->belongsTo("App\CourseSpecialization", 'course_specialization_id', 'id')->first();
    }

    public function specializations()
    {
        return $this->belongsTo("App\CourseSpecialization", 'course_specialization_id', 'id');
    }

    public function courseUsers(): BelongsToMany
    {
        return $this->belongsToMany("App\User", 'App\CourseUsers', 'course_id', 'user_id', 'id', 'id');
    }

    public function getCourseUsers(): Collection
    {
        return $this->belongsToMany("App\User", 'App\CourseUsers', 'course_id', 'user_id', 'id', 'id')->get();
    }

    public function teachers(): HasOneThrough
    {
        return $this->hasOneThrough("App\Teacher", 'App\User', 'id', 'user_id', 'user_id', 'id');
    }

    public function promotion(): Collection
    {
        return $this->hasMany("App\Promotion", 'course_id')->get();
    }

    public function promotions(): HasMany
    {
        return $this->hasMany("App\Promotion", 'course_id')->orderBy('start_at');
    }

    public function promotionPurchase(): HasManyThrough
    {
        return $this->hasManyThrough(
            "App\PromotionPurchase",
            "App\Promotion",
            "course_id",
            "promotion_id",
            "id"
        )->withTrashedParents()->where(function ($query) {
                $query->where('paid', '=', PromotionPurchase::PAID_PAID);
        });
    }

    public function promotionPurchases()
    {
        return $this->hasManyThrough(
            "App\PromotionPurchase",
            "App\Promotion",
            "course_id",
            "promotion_id",
            "id"
        )->withTrashedParents()->where('paid', PromotionPurchase::PAID_PAID);
    }

    public function courseReviews(): HasMany
    {
        return $this->hasMany('App\CourseReviews', 'course_id');
    }

    public function getCourseReviews(): Collection
    {
        return $this->hasMany('App\CourseReviews', 'course_id')->get();
    }

    public function user_assistant(): HasManyThrough
    {
        return $this->hasManyThrough(
            "App\UserAssistant",
            "App\PromotionPurchase",
            "user_id",
            "id",
            "user_id",
            "user_id"
        );
    }

    public function faqs(): HasMany
    {
        return $this->hasMany("App\CoursesFaq", 'course_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany("App\PricesStripe", 'course_id');
    }

    public function pricesPacks(): HasMany
    {
        return $this->hasMany("App\PricesStripe", 'course_id')->where('prices_id_stripe_old')->orderBy('id');
    }

    public function pricesEnrollment(): HasMany
    {
        return $this->hasMany("App\PricesStripe", 'course_id')->where('model_type', PricesStripe::TYPE_ENROLLMENT);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            "course_rel_tag",
            "course_id",
            "tag_id",
            "id"
        );
    }

    /**********************************************************/
    /**********************************SCOPES******************/
    /*********************************************************/

    public function scopeActiveCourses($query, $active = true)
    {
        if (isset($active)) {
            if ($active) {
                return $query->whereHas('promotions', function (Builder $query) {
                    $query->where('start_at', '>', now()->format('Y-m-d'));
                });
            } else {
                return $query->whereHas('promotions', function (Builder $query) {
                    $query;
                });
            }
        }
        return $query->whereHas('promotions', function (Builder $query) {
            $query;
        });
    }

    public function scopeJoinFavouritesCourseFilterByUserFavourites($query, $user_id)
    {
        return $query->select('courses.id')->selectRaw('favourites_courses.course_id, favourites_courses.user_id as user_login_id')
            ->leftjoin('favourites_courses', function ($join) use ($user_id) {
                $join->on('favourites_courses.course_id', '=', 'courses.id')
                    ->where([ "favourites_courses.user_id" => $user_id ]);
            })
            ->groupBy('courses.created_at', 'courses.id', 'favourites_courses.user_id', 'favourites_courses.course_id');
    }

    public function scopeCountHistoricalCourses($query)
    {
        return $query->selectRaw('courses.id, count(courses_historical_viewed.id) as `most_views`')
            ->leftjoin('courses_historical_viewed', 'courses.id', '=', 'courses_historical_viewed.course_id')
            ->groupBy('courses.id', 'courses.created_at')->orderBy('most_views', 'DESC');
    }

    public function scopeCountFavouritesCourses($query)
    {
        return $query->selectRaw('courses.id, count(favourites_courses.id) as `likes`')
            ->leftjoin('favourites_courses', 'courses.id', '=', 'favourites_courses.course_id')
            ->groupBy('courses.id', 'courses.created_at')->orderBy('likes', 'DESC');
    }

    public function scopeJoinCountFavoritesCourses($query, $count)
    {
        return $query->joinSub($count, 'count_likes', function ($join) {
            $join->on('courses.id', '=', 'count_likes.id');
        });
    }

    public function scopeListCoursesAllFeatured($query, $is_featured = true)
    {
        return $query->where([ "is_visible" => true, "is_featured" => $is_featured ])->orderBy('courses.created_at', 'desc');
    }

    public function scopeListCoursesFilters($query)
    {
        return $query->where([ "courses.is_visible" => true ])->orderBy('courses.created_at', 'desc');
    }

    public function scopeFilter($query, $parameters)
    {
        if (isset($parameters[ 'courses_category_id' ]) && trim($parameters[ 'courses_category_id' ] !== '')) {
            $query->whereIn('courses_category_id', $parameters[ 'courses_category_id' ]);
        }
        if (isset($parameters[ 'age_active' ]) && isset($parameters[ 'age' ]) && trim($parameters[ 'age' ] !== '')) {
            //student_ages_max>=$filter_age AND student_ages_min<=$filter_age
            // dd("First");
            $query->where("student_ages_max", ">=", $parameters[ 'age' ])->where("student_ages_min", "<=", $parameters[ 'age' ]);
        }
        if (isset($parameters[ 'price_active' ]) && isset($parameters[ 'price' ]) && trim($parameters[ 'price' ] !== '')) {
            //price_total<=$request->price
            // dd("Second");
            $query->where("price_total", "<=", $parameters[ 'price' ]);
        }
        if (isset($parameters[ 'duration_active' ]) && isset($parameters[ 'duration' ]) && trim($parameters[ 'duration' ] !== '')) {
            // dd("Third");
            $query->where("duration", "<=", $parameters[ 'duration' ]);
        }
        return $query;
    }

    public function scopeIsPurchasable($query, $condition = true)
    {
        if (isset($condition)) {
            if ($condition === 'true' || $condition === true) {
                return $query->whereHas('promotions', function (Builder $query) {
                    return $query->where('start_at', '>=', now()->addDay());
                });
            }
            return $query->whereHas('promotions', function (Builder $query) {
                return $query;
            });
        }
        return $query->whereHas('promotions', function (Builder $query) {
            return $query;
        });
    }

    public function skills()
    {
        return $this->belongsToMany("App\Skill", 'course_skills', 'course_id', 'skill_id', 'id', 'id');
    }

    public function requirements()
    {
        return $this->belongsToMany("App\Requirement", 'course_requirements', 'course_id', 'requirement_id', 'id', 'id');
    }

    public function requirement()
    {
        $id8GB = 931;
        $lack8GB = true;
        $requirements = $this->belongsToMany("App\Requirement", 'course_requirements', 'course_id', 'requirement_id', 'id', 'id')->get();
        foreach ($requirements as $requirement) {
            if ($requirement->id == $id8GB) {
                $lack8GB = false;
                break;
            }
        }

        if ($lack8GB) {
            $requirement8GB = Requirement::find($id8GB);
            $requirements->add($requirement8GB);
        }

        return $requirements;
    }

    public function courseRequirements(): HasMany
    {
        return $this->hasMany("App\CourseRequirements", 'course_id');
    }

    public function scopeStartsAfter($query, $date1)
    {
        return $query->whereHas('promotions', function (Builder $query) use ($date1) {
            $query->select('start_at')->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')->orderBy('start_at')->where('start_at', '<', $date1);
        });
        //return $query->whereHas('promotions',function(Builder $query)use($date){ $query->selectRaw('MIN(start_at) as start_at')->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')->where('start_at', '<=', Carbon::parse($date));});
    }

    public function scopeStartsAfterHour($query, $hour1, $hour2)
    {
        return $query->whereHas('promotions', function (Builder $query) use ($hour1, $hour2) {
            $query->select('start_at')->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')
                ->orderBy('start_at')->whereBetween(\DB::raw('TIME(start_at)'), [ $hour1, $hour2 ]);
        });
    }

    public function scopeCategoriesName($query, $categories)
    {
        $this->joinSpecializations($query);
        $this->joinCategories($query);
        return $query->where(['course_category.slug' => $categories]);
    }

    public function scopeSpecializationsName($query, $categories)
    {
        $this->joinSpecializations($query);
        return $query->where(['course_specialization.slug' => $categories]);
    }

    public function scopeAreasName($query, $categories)
    {
        $this->joinSpecializations($query);
        $this->joinCategories($query);
        $this->joinAreas($query);
        return $query->where(['course_area.slug' => $categories]);
    }

    public function scopePriceBetween($query, $price1, $price2)
    {
        return $query->whereBetween('price_total', [ $price2, $price1 ]);
    }

    public function scopeAgeBetween($query, $age1, $age2)
    {
        return $query->where('student_ages_max', '>=', $age2)->where('student_ages_min', '<=', $age1);
    }

    public function scopeSearchBy(Builder $query, $text): Builder
    {
        return $query->orWhere('title', 'like', "%{$text}%")
            ->orWhereHas('categories', function (Builder $query) use ($text) {
                $query->select('title')->where('title', 'like', "%{$text}%");
            })
            /*
            ->orWhereHas('users', function (Builder $query) use ($text) {
                $query->select('name')->where('name', 'like', "%{$text}%");
            })
            */
            ;
    }

    public function scopePromotionPurchaseUserId($query, $user_id)
    {
        return $query->whereHas('promotionPurchase', function (Builder $query) use ($user_id) {
            /*$query->leftjoin('course_users', function ($join) use ($user_id) {
                $join->on('course_users.course_id', '=', 'courses.id')
                    ->where([ "course_users.user_id" => $user_id ]);
            });*/
            //$query->leftJoin('course_users','course_users.course_id', '=', 'courses.id');
            $query->where([ 'paid' => PromotionPurchase::PAID_PAID]);
        });
    }

    public function scopePromotionPurchasePaymentStatus($query, $status)
    {
        return $query->whereHas('promotionPurchase', function (Builder $query) use ($status) {
            $query->where('paid', '=', PromotionPurchase::PAID_PAID);
        });
    }

    public function scopePromotionsState($query, $state)
    {
        return $query->whereHas('promotions', function (Builder $queryPromo) use ($state, $query) {
            return $queryPromo->StartAtEndAt($state);
        });
    }

    public function scopeSkillsName($query, $name)
    {
        return $query->whereHas('skills', function (Builder $query) use ($name) {
            $query->where('skill_name', '=', $name);
        });
    }

    public function scopeDailies($query, $dailies)
    {
        return $query->whereIn('daily', [ $dailies ]);
    }

    public function toFeedItem(): FeedItem
    {
        if (empty($this->title)) {
            $this->title = '';
        }
        if (empty($this->intro)) {
            $this->intro = '';
        }
        if (empty($this->updated_at)) {
            $this->updated_at = '';
        }
        $link = $this->getLink();

        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->author('Lifecole')
            ->summary($this->intro)
            ->updated($this->updated_at)
            ->link($link);
    }

    public static function getFeedItems()
    {
        return static::whereHas('promotions', function (Builder $query) {
            $query->selectRaw('course_id, MIN(start_at) as start_at')->whereRaw('DATE_SUB(start_at,INTERVAL 5 MINUTE) >=NOW()')->groupBy('course_id');
        })
            ->ListCoursesFilters(true)->get();
    }

    public function getSameCategories($field)
    {
        return static::where([ "courses_category_id" => $this->courses_category_id ])->pluck($field);
    }

    public function getRawTotalReviews(): int
    {
        return $this->getRawOriginal('total_reviews');
    }

    public function getTotalReviewsAttribute($value)
    {
        if ($value == 0) {
            $title = $this->getOriginal('title');
            return (strlen($title)  % 2) + 2;
        }
        return $value;
    }

    public function getAvgReviewsAttribute($value)
    {
        if ($value == 0) {
            $title = $this->getOriginal('title');
            return ((strlen($title)  % 7) / 10) + 4.1;
        }
        return $value;
    }

    private function joinSpecializations($query)
    {
        if (!isset($this->joins['Specializations'])) {
            $query->select('courses.*')->join('course_specialization', 'courses.course_specialization_id', '=', 'course_specialization.id');
            $this->joins['Specializations'] = true;
        }
    }

    private function joinCategories($query)
    {
        if (!isset($this->joins['Categories'])) {
            $query->select('courses.*')->join('course_category', 'course_specialization.course_category_id', '=', 'course_category.id');
            $this->joins['Categories'] = true;
        }
    }

    private function joinAreas($query)
    {
        if (!isset($this->joins['Areas'])) {
            $query->select('courses.*')->join('course_area', 'course_category.course_area_id', '=', 'course_area.id');
            $this->joins['Areas'] = true;
        }
    }

    public function scopeTagsName($query, $slug)
    {
        return $query->whereHas('tags', function (Builder $query) use ($slug) {
            $query->select('slug')->where('slug', $slug);
        });
    }
}
