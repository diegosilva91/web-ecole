<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursesHistoricalViewed extends Model
{
    protected $table = 'courses_historical_viewed';
    protected $fillable = ['course_id', 'user_id', 'counter'];
}
