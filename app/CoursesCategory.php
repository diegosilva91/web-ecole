<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CoursesCategory extends Model
{
    public $timestamps = false;
    protected $table = 'course_categories';
    protected $fillable = ['title'];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->slug == "") {
                $model->slug = Str::slug($model->title, '-');
            }
        });
    }

    public function courses()
    {
        return $this->hasMany("App\Course", 'course_category_id');
    }

    public function scopeFilter($query, $parameters)
    {
        //dd(explode(",",$params['categories']));// "Artes,etc,etc"
        //dd('['.$params['categories'] .']');
        if (isset($parameters['categories']) && trim($parameters['categories'] !== '')) {
            $query->whereIn('title', explode(",", $parameters['categories']));
        }
        return $query;
    }
}
