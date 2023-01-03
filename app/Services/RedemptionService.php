<?php

namespace App\Services;

use App\Exceptions\InvalidRedeemDataException;
use App\Http\Helpers\CommonHelper;
use App\Models\CouponCategory;
use App\Models\User;
use App\Repositories\RedemptionRepository;

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

    /**
     * @var CommonHelper
     */
    private $commonHelper;

    public function __construct(
        RedemptionRepository $redemptionRepository,
        PointService $pointService,
        CouponService $couponService,
        CommonHelper $commonHelper
    ) {
        $this->redemptionRepository = $redemptionRepository;
        $this->pointService = $pointService;
        $this->couponService = $couponService;
        $this->commonHelper = $commonHelper;
    }

    /**
     * @throws InvalidRedeemDataException
     */
    public function redeem(CouponCategory $couponCategory, User $user)
    {
        $this->validate($couponCategory, $user);

        $redemption = $this->redemptionRepository->create([
            'user_id' => $user->id,
            'coupon_category_id' => $couponCategory->id,
        ]);

        $key = $this->commonHelper->hashSha256(40);
        $strCode = "$user->name | $key";
        $coupon = $this->couponService->create([
            'key' => $key,
            'status' => config('constant.coupon.statues.enable'),
            'quota' => 1,
            'qr' => $this->commonHelper->bash64QrCode($strCode),
            'price' => $couponCategory->price,
            'type' => config('constant.coupon.types.unique'),
            'redemption_id' => $redemption->id,
        ]);

        $this->pointService->decrease($user->point, $couponCategory->required_point);

        $this->couponService->updateCategory(['quota' => $couponCategory->quota - 1], $couponCategory->id);

        return $coupon;
    }

    /**
     * @throws InvalidRedeemDataException
     */
    private function validate(CouponCategory $couponCategory, User $user)
    {
        if ($couponCategory->status != config('constant.coupon.statues.enable')) {
           throw new InvalidRedeemDataException('Coupon is not active!');
        }

        if (!$couponCategory->quota) {
            throw new InvalidRedeemDataException('Coupon quota exceeded!');
        }

        $point = $user->point;
        if (!$point || $point->point_value < $couponCategory->required_point) {
            throw new InvalidRedeemDataException('You do not have enough Point!');
        }
    }
}
