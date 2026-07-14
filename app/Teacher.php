<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Str;

class Teacher extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bio','cover_image','title','bio','user_id','slug','total_reviews','avg_reviews','rating1','rating2','rating3','rating4'
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->slug == "") {
                $model->slug = Str::slug($model->title, '-');
            }
        });
    }

    public function reviews()
    {
        return $this->hasMany("App\TeachersReview", "teacher_id")->get();
    }

    public function courses(): HasOneThrough
    {
        return $this->hasOneThrough("App\Course", 'App\User', 'id', 'user_id', 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo("App\User", 'user_id')->first();
    }
}
