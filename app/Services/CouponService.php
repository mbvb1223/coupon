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

    public function create(array $attributes)
    {
        return $this->couponRepository->create($attributes);
    }

    public function updateCategory(array $attributes, int $id)
    {
        return $this->couponRepository->updateCategory($attributes, $id);
    }
}
