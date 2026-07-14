<?php

namespace App\Http\Controllers\Web\Payment;

use App\Coupon;
use App\Course;
use App\Http\Controllers\Controller;
use App\Promotion;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShowPaymentView extends Controller
{
    public function showPaymentView(Request $request, $course_id, $promotion_id): Factory|\Illuminate\Contracts\View\View|Application
    {
        $coupon_name = '';
        if ($request->has([ 'coupon_id', 'coupon' ])) {
            $coupon = Coupon::where([ 'owner_id' => $request->query('coupon_id'), 'code' => $request->query('coupon') ])->first();
            if ($coupon) {
                $coupon_name = $coupon->code;
            }
        }

        $user = User::with('UserAssistant')->where('id', Auth::id())->first();
        if ($user) {
            Log::info('User in payment load ' . $user->email);
        }

        $promotion = Promotion::find($promotion_id);
        if (!$promotion) {
            abort(404, 'Page not found');
        }

        $course = Course::find($course_id);
        if (!$course) {
            abort(404, 'Page not found');
        }

        $promotions = $course->promotions()->IsPurchasable(true)->ActivePromotions(true)->cursor();
        $promotion_exist = $promotions->where('id', $promotion_id)->count();
        if ($promotion_exist <= 0) {
            return view('pages.payment', [ 'promotion' => $promotion, 'course' => $course, 'user' => $user, 'coupon' => $coupon_name, 'promotions' => $promotions, 'modalToHome' => true ]);
        }
        $promotions = $promotions->filter(function ($promotion) {
            if (isset($promotion->courses) && isset($promotion->promotionPurchases)) {
                return $promotion->courses->students_max > $promotion->promotionPurchases->count();
            }
        })->toArray();
        $promotions = array_values($promotions);

        return view('pages.payment', [ 'promotion' => $promotion, 'course' => $course, 'user' => $user, 'coupon' => $coupon_name, 'promotions' => $promotions ]);
    }
}
