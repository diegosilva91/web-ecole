<?php

namespace App\Http\Controllers\Web\Teachers;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Lifecole\Api\Domain\Helper\AddPriceHour;
use Lifecole\Api\Domain\Helper\FillSubcategories;

class CoursesTeacherController extends Controller
{
    public function coursesTeacher(AddPriceHour $addPriceHour, FillSubcategories $fillSubcategories)
    {
        $user = User::find(Auth::id());
        $featuredCourses = $user->teacherCourse()->get();
        $addPriceHour->apply($featuredCourses);
        $fillSubcategories->apply($featuredCourses);

        return view('pages.courses-teacher', ['featuredCourses' => $featuredCourses]);
    }
}
