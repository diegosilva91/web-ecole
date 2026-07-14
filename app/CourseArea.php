<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CourseArea extends Model
{
    public $timestamps = false;
    protected $table = 'course_area';
    protected $fillable = ['title'];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->slug == '') {
                $model->slug = Str::slug($model->title, '-');
            }
        });
    }

    public function categories(): Collection
    {
        return $this->belongsTo("App\CourseCategory", 'course_category_id')->get();
    }
}
