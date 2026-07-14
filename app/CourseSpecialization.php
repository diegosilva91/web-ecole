<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CourseSpecialization extends Model
{
    public $timestamps = false;
    protected $table = 'course_specialization';
    protected $fillable = ['course_category_id','title'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->slug == '') {
                $model->slug = Str::slug($model->title, '-');
            }
        });
    }

    public function category()
    {
        return $this->belongsTo("App\CourseCategory", 'course_category_id')->first();
    }

    public function courses()
    {
        return $this->hasMany("App\Course", 'course_specialization_id');
    }
}
