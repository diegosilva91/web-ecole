<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavouritesCourses extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'course_id'];

    public function courses()
    {
        return $this->hasMany("App\Course", 'course_id');
    }

    public function users()
    {
        return $this->hasOne("App\User", 'id', 'user_id');
    }

    public function scopeFilterUserGroupCourse($query, $user_id)
    {
        return $query->select("course_id", "user_id")->where(["user_id" => $user_id])->groupBy("course_id", "user_id");
    }

    public function scopeFilterUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
