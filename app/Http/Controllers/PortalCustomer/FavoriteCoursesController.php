<?php

namespace App\Http\Controllers\PortalCustomer;

use App\Http\Controllers\Controller;
use Auth;
use Lifecole\Api\Domain\Helper\AddPriceHour;

class FavoriteCoursesController extends Controller
{
    public function listFavoritesCourses(AddPriceHour $addPriceHour)
    {
        $favoritesCourses = \App\Course::select('courses.*')
            ->join('favourites_courses', 'courses.id', '=', 'favourites_courses.course_id')
            ->where(['favourites_courses.user_id' => Auth::id()])
            ->orderBy('created_at', 'desc')->get();
        $addPriceHour->apply($favoritesCourses);

        return view('pages.courses-favorites', ['featuredCourses' => $favoritesCourses]);
    }
}
