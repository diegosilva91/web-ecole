<?php

namespace Mi-empresa\Api\Domain\Helper;

use App\Course;

class AddPriceHour
{
    public function apply($courses)
    {
        if ($courses instanceof Course) {
            $this->applyToCourse($courses);
        } else {
            $courses->map(function ($value) {
                $this->applyToCourse($value);
            });
        }
    }

    private function applyToCourse(Course $course)
    {
        if (isset($course->duration) && isset($course->sessionTime)) {
            $duration = $course->duration != 0 ? (int) $course->duration : 1;
            $session = $course->sessionTime != 0 ? $course->sessionTime / 60 : 1;
        } else {
            $duration = 4;
            $session = 1;
        }
        if (isset($course->price_total)) {
            $price_total=$course->price_total;
            if (isset($course->discount) && $course->discount !== '0.00') {
                $price_total = $course->price_total - ($course->price_total * ($course->discount)/100);
            }
            $course->price_per_hour = (int) ((int) $price_total / ($session * $duration));
        } else {
            $course->price_per_hour = 0;
        }
    }
}
