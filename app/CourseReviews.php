<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseReviews extends Model
{
    protected $fillable = ['user_id', 'teacher_id', 'course_id', 'rating1', 'rating2', 'rating3', 'rating4', 'opinion'];

    public function course(): BelongsTo
    {
        return $this->belongsTo("App\Course", 'course_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo("App\User", 'user_id');
    }
}
