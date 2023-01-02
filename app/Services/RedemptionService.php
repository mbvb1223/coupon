<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use App\Repositories\RedemptionRepository;
use Illuminate\Support\Str;

class RedemptionService
{
    /**
     * @var RedemptionRepository
     */
    private $redemptionRepository;
    /**
     * @var PointService
     */
    private $pointService;

    public function __construct(
        RedemptionRepository $redemptionRepository,
        PointService         $pointService
    ) {
        $this->redemptionRepository = $redemptionRepository;
        $this->pointService = $pointService;
    }

    public function redeem(Coupon $coupon, User $user)
    {
        if ($coupon->status != config('constant.coupon.statues.enable')) {
            echo 'false';
        }

        $point = $user->point;
        if (!$point || $point->point_value < $coupon->required_point) {
            echo 'xxx';
        }

        $redemption = $this->redemptionRepository->create([
            'user_id' => $user->id,
            'key' => hash('sha256', Str::random(40)),
            'status' => 1
        ]);

        $this->pointService->decrease($point, $coupon->required_point);

        return $redemption;
    }
}
