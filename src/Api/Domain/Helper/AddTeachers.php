<?php

namespace Lifecole\Api\Domain\Helper;

use App\Course;
use App\User;

class AddTeachers
{
    public function apply($courses)
    {
        if ($courses instanceof Course) {
            $courses->count_teachers=count($this->applyToCourse($courses));
        } else {
            $courses->map(function ($value) {
                $value->count_teachers=count($this->applyToCourse($value));
            });
        }
    }

    private function applyToCourse(Course $course): array
    {
        $teachers=[];
        if ($course instanceof Course) {
            if (is_array($course->getCourseUsers()->all())) {
                $teachers = $course->getCourseUsers()->all();
            }
        }
        return $teachers;
    }
}
