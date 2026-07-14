<?php

namespace App\Http\Controllers\Api\Coupons;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetUserCouponsController extends Controller
{
    public function getCoupons(): JsonResponse
    {
        if (Auth::id()) {
            $coupon = Coupon::where('owner_id', Auth::id())->first();
            return response()->json(['coupon' => $coupon]);
        }
        return response()->json([]);
    }
}
