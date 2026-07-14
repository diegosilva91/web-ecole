<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRecommender extends Model
{
    protected $fillable = ['user_id', 'token_typeform', 'u_key', 'recommender_type'];
}
