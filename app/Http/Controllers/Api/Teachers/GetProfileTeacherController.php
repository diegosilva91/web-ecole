<?php

namespace App\Http\Controllers\Api\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Traits\TeacherServicesTrait;
use App\PromotionPurchase;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Lifecole\Api\Domain\Adapter\CdnAdapter;

class GetProfileTeacherController extends Controller
{
    use TeacherServicesTrait;

    public function getTeacherPerfil($id, CdnAdapter $cdnAdapter): JsonResponse
    {
        if (Auth::check() || Auth::guard('api')->check()) {
            if (!Auth::user()->hasRole('admin') && (int)$id !== Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 419);
            }
        } else {
            return response()->json(['error' => 'Unauthorized only auth session'], 419);
        }

        $user = User::with(['teacher', 'teacherCourse' => function ($query) {
            $query->where(['is_visible' => '1']);
        }])->CountPromotionPurchase(PromotionPurchase::PAID_PAID)->where("id", $id)->first();
        $this->addCountCourses($user);
        $this->addAvgCoursePuntuation($user);
        $this->addAvgCourseValorations($user);

        return response()->json(['user' => $user, 'url' => $cdnAdapter->base()]);
    }
}
