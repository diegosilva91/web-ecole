<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    public $timestamps = false;
    protected $table = 'course_category';
    protected $fillable = ['course_area_id','title'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->slug == '') {
                $model->slug = Str::slug($model->title, '-');
            }
        });
    }

    public function area()
    {
        return $this->hasOne("App\CoursesArea", 'course_area_id')->first();
    }

    public function areaPreBuild()
    {
        return $this->hasOne("App\CourseArea", 'id', 'course_area_id');
    }
    public function specializations(): Collection
    {
        return $this->belongsTo("App\CourseSpecialization", 'course_specialization_id')->get();
    }
}
