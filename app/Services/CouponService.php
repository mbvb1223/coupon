<?php

namespace App\Services;

use App\Repositories\CouponRepository;

class CouponService
{
    /**
     * @var CouponRepository
     */
    private $couponRepository;

    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function update(array $attributes, int $id)
    {
        return $this->couponRepository->update($attributes, $id);
    }
}
