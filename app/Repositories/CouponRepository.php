<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\CouponCategory;

class CouponRepository
{
    public function create(array $attributes)
    {
        return Coupon::create(array_merge($attributes));
    }

    public function updateCategory(array $attributes, int $id)
    {
        $couponCategory = CouponCategory::find($id);

        return $couponCategory->update($attributes);
    }
}
