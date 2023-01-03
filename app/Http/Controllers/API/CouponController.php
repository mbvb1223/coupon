<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidRedeemDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateCouponRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\CouponCategory;
use App\Services\RedemptionService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * @var RedemptionService
     */
    private $redemptionService;

    public function __construct(RedemptionService $redemptionService)
    {
        $this->redemptionService = $redemptionService;
    }

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
    public function categories()
    {
        $couponCategories = CouponCategory::all();

        return new SuccessResponse('Ok!', $couponCategories);
    }

    /**
     * @OA\Put(
     *     path="/coupons/{coupon}",
     *     summary="Update a coupon",
     *     tags={"Coupons"},
     *     security={ {"sanctum": {} }},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         ),
     *         style="form"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             @OA\Schema(
     *                 example={"email": "phamkhien@hotmail.com", "password": "123456", "device_name": "iphone 2000"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Examples(example="result", value= {
    "success": true,
    "code": 201,
    "message": "Created successfully!",
    "data": "2|B9tN94NEoV5sRsK1y59djIKHVSgDq0JkWwV3oiAP"
    }, summary="An result object."),
     *         )
     *     )
     * )
     */
    public function update(UpdateCouponRequest $request, CouponCategory $couponCategory)
    {
        $couponCategory->name = $request->name ?? $couponCategory->name;
        $couponCategory->quota = $request->quota ?? $couponCategory->quota;
        $couponCategory->required_point = $request->required_point ?? $couponCategory->required_point;

        $couponCategory->save();

        return new SuccessResponse('Ok!', $couponCategory);
    }

    public function redeem(Request $request, CouponCategory $couponCategory)
    {
        $user = $request->user();

        try {
            $redemption = $this->redemptionService->redeem($couponCategory, $user);
        } catch (InvalidRedeemDataException $invalidRedeemDataException) {
            return new ErrorResponse($invalidRedeemDataException->getMessage(), null, 409);
        } catch (\Throwable $throwable) {
            return new ErrorResponse($throwable->getMessage());
        }

        return new SuccessResponse('Ok!', $redemption);
    }
}
