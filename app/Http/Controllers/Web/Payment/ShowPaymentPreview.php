<?php

namespace App\Http\Controllers\Web\Payment;

use App\Coupon;
use App\Course;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowPaymentPreview extends Controller
{
    public function showPaymentPreview(Request $request, $course_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            abort(404, "Page not found");
        }
        $user = User::with('UserAssistant')->where("id", Auth::id())->first();
        if ($user) {
            //Log::info("User in payment load " . $user->email);
        }
        $coupon_name = "";
        if ($request->has(['coupon_id', 'coupon'])) {
            $coupon = Coupon::where(["owner_id" => $request->query("coupon_id"), "code" => $request->query("coupon")])->first();
            if ($coupon) {
                $coupon_name = $coupon->code;
            }
        }
        $promotions = $course->promotions()->IsPurchasable(true)->ActivePromotions(true)->cursor();
        $promotions = $promotions->filter(function ($promotion) {
            if (isset($promotion->courses) && isset($promotion->promotionPurchases)) {
                return $promotion->courses->students_max > $promotion->promotionPurchases->count();
            }
        })->toArray();
        $promotions = array_values($promotions);

        return view("pages.payment", ["promotion" => null, "course" => $course, "user" => $user, "coupon" => $coupon_name, "promotions" => $promotions]);
    }
}
