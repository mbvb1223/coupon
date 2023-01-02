<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\Coupon;
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

    public function redeem(Request $request, Coupon $coupon)
    {
        $user = $request->user();

        $redemption = $this->redemptionService->redeem($coupon, $user);

        return new SuccessResponse('Ok!', $redemption);
    }
}
