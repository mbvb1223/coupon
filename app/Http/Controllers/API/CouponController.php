<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateCouponRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * @OA\Get(
     *     path="/coupons",
     *     summary="List coupons",
     *     tags={"Coupons"},
     *     security={ {"sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value={
                    "success": true,
                    "code": 200,
                    "message": "Ok!",
                    "data": {
                        {
                            "id": 1,
                            "name": "Christmas 2023",
                            "status": 1,
                            "quota": 200,
                            "required_point": 50,
                            "price": 500,
                            "created_at": "2023-01-02T16:35:08.000000Z",
                            "updated_at": "2023-01-02T16:35:08.000000Z",
                            "deleted_at": null
                        },
                        {
                            "id": 2,
                            "name": "New Year 2023",
                            "status": 1,
                            "quota": 97,
                            "required_point": 1,
                            "price": 10,
                            "created_at": "2023-01-02T16:35:08.000000Z",
                            "updated_at": "2023-01-02T16:40:58.000000Z",
                            "deleted_at": null
                        }
                    }
    }, summary="An result object."),
     *         )
     *     )
     * )
     */
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
