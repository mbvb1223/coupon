<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateCouponRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();

        return new SuccessResponse('Ok!', $coupons);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->name = $request->name ?? $coupon->name;
        $coupon->quota = $request->quota ?? $coupon->quota;
        $coupon->required_point = $request->required_point ?? $coupon->required_point;

        $coupon->save();

        return new SuccessResponse('Ok!', $coupon);
    }
}
