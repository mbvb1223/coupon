<?php

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidRedeemDataException;
use App\Http\Controllers\Controller;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\CouponCategory;
use App\Services\RedemptionService;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    /**
     * @var RedemptionService
     */
    private $redemptionService;

    public function __construct(RedemptionService $redemptionService)
    {
        $this->redemptionService = $redemptionService;
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
