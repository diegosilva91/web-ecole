<?php

namespace App\Http\Controllers\Web\Payment;

use App\Coupon;
use App\Course;
use App\Http\Controllers\Controller;
use App\PromotionPurchase;
use App\PromotionPurchasePayment;

class ShowPaymentViewSuccess extends Controller
{
    public function showPaymentViewSuccess($course_id, $promotion_purchase_id)
    {
        if (!$promotion_purchase_id) {
            abort(404, 'Page not found');
        }

        $promotionPurchase = PromotionPurchase::find($promotion_purchase_id);
        if (!$promotionPurchase) {
            abort(404, 'Page not found');
        }

        $promotionPurchasePayment = PromotionPurchasePayment::where([ 'promotion_purchase_id' => $promotionPurchase->id ])->first();
        if (!$promotionPurchasePayment) {
            abort(404, 'Page not found');
        }

        $course = Course::find($course_id);
        if (!$course) {
            abort(404, 'Page not found');
        }

        $promotion = $promotionPurchase->promotion();

        if (isset($promotionPurchasePayment->coupon_id)) {
            $coupon = Coupon::find($promotionPurchasePayment->coupon_id);
            return view('pages.payment-success', [ 'promotionPurchase' => $promotionPurchase, 'promotionPurchasePayment' => $promotionPurchasePayment, 'promotion' => $promotion, 'course' => $course, 'coupon' => $coupon ]);
        }

        return view('pages.payment-success', [ 'promotionPurchase' => $promotionPurchase, 'promotionPurchasePayment' => $promotionPurchasePayment, 'promotion' => $promotion, 'course' => $course, 'coupon' => null ]);
    }
}
