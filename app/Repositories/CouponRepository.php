<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository
{
    public function update(array $attributes, int $id)
    {
        $coupon = Coupon::find($id);

        return $coupon->update($attributes);
    }
}
