<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    protected $table = 'tag';
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
}
