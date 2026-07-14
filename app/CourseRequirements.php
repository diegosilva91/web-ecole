<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirements extends Model
{
    public $timestamps = false;
    protected $fillable = ['requirement_id'];
}
