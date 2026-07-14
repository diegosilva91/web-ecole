<?php

namespace App\Http\Traits;

use App\User;

trait TeacherServicesTrait
{
    static function checkModel($model): bool
    {
        if ($model instanceof User) {
            return true;
        } else {
            return false;
        }
    }

    public function addCountCourses($user)
    {
        if (self::checkModel($user)) {
            $user->count_courses_active = $user->teacherCourse->count();
        }
        return $user;
    }

    public function addAvgCoursePuntuation($user)
    {
        if (self::checkModel($user)) {
            $user->avg_course_puntuation = isset($user->teacherCourse) ? $user->teacherCourse->avg('avg_reviews') : 0;
        }
        return $user;
    }

    public function addAvgCourseValorations($user)
    {
        if (self::checkModel($user)) {
            $user->avg_course_valorations = $user->teacherCourse->avg('total_reviews');
        }
        return $user;
    }
}
