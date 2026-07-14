<?php

namespace App\Http\Controllers\Web\Courses;

use App\Course;
use App\Http\Controllers\Controller;

class ShowFeedCourseController extends Controller
{
    public function show(Course $course)
    {
        return $course;
    }
}
