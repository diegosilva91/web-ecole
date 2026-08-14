<?php

namespace Mi-empresa\Api\Domain\Helper;

use App\Course;

class FillSubcategories
{
    public function apply($courses)
    {
        if ($courses instanceof Course) {
            $this->applyToCourse($courses);
        } else {
            $courses->map(function ($course) {
                $this->applyToCourse($course);
            });
        }
    }

    private function applyToCourse(Course $course): void
    {
        $course->categoryName = $course->specialization()->category()->title;
    }
}
