<?php

namespace App\Services;

use App\Exceptions\InvalidRedeemDataException;
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

    /**
     * @var CouponService
     */
    private $couponService;

    public function __construct(
        RedemptionRepository $redemptionRepository,
        PointService $pointService,
        CouponService $couponService
    ) {
        $this->redemptionRepository = $redemptionRepository;
        $this->pointService = $pointService;
        $this->couponService = $couponService;
    }

    /**
     * @throws InvalidRedeemDataException
     */
    public function redeem(Coupon $coupon, User $user)
    {
        $this->validate($coupon, $user);

        $key = hash('sha256', Str::random(40));
        $redemption = $this->redemptionRepository->create([
            'user_id' => $user->id,
            'coupon_id' => $coupon->id,
            'key' => $key,
            'price' => $coupon->price,
            'qr' => base64_encode(QrCode::format('png')->size(100)->generate("$user->name | $key")),
            'status' => config('constant.redemption.statues.enable'),
        ]);

        $this->pointService->decrease($user->point, $coupon->required_point);

        $this->couponService->update(['quota' => $coupon->quota - 1], $coupon->id);

        return $redemption;
    }

    /**
     * @throws InvalidRedeemDataException
     */
    private function validate(Coupon $coupon, User $user)
    {
        if ($coupon->status != config('constant.coupon.statues.enable')) {
           throw new InvalidRedeemDataException('Coupon is not active!');
        }

        if (!$coupon->quota) {
            throw new InvalidRedeemDataException('Coupon quota exceeded!');
        }

        $point = $user->point;
        if (!$point || $point->point_value < $coupon->required_point) {
            throw new InvalidRedeemDataException('You do not have enough Point!');
        }
    }
}
