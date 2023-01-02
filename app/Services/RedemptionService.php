<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use App\Repositories\RedemptionRepository;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

        $key = hash('sha256', Str::random(40));
        $redemption = $this->redemptionRepository->create([
            'user_id' => $user->id,
            'key' => $key,
            'qr' => base64_encode(QrCode::format('png')->size(100)->generate("$user->name | $key")),
            'status' => 1,
        ]);

        $this->pointService->decrease($point, $coupon->required_point);

        return $redemption;
    }
}
