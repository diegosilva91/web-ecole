<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'cover_icon'];

    public function course()
    {
        return $this->belongsToMany("App\Course", 'course_id', 'requirement_id');
    }
}
